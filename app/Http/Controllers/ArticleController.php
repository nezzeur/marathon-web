<?php

namespace App\Http\Controllers;

use App\Models\Accessibilite;
use App\Models\Article;
use App\Models\Conclusion;
use App\Models\Rythme;
use App\Models\User;
use App\Notifications\NewArticleFromFollowedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Page d'accueil : affiche les articles (derniers publiés)
    public function index()
    {
        $query = Article::where('en_ligne', true);
        
        // Si l'utilisateur est connecté, on ajoute ses articles même hors ligne
        if (auth()->check()) {
            $userId = auth()->id();
            $query->orWhere(function($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        
        $articles = $query->inRandomOrder()->limit(6)->get();
        
        // Récupérer les 3 articles les plus vus
        $articlesPlusVus = $this->getArticlesPlusVus();
        
        // Récupérer les 3 articles les plus likés
        $articlesPlusLikes = $this->getArticlesPlusLikes();
        
        return view('home', compact('articles', 'articlesPlusVus', 'articlesPlusLikes'));
    }

    /**
     * Récupère les 3 articles les plus vus
     */
    protected function getArticlesPlusVus()
    {
        return Article::where('en_ligne', true)
            ->orderBy('nb_vues', 'desc')
            ->limit(3)
            ->get();
    }

    /**
     * Récupère les 3 articles les plus likés
     */
    protected function getArticlesPlusLikes()
    {
        return Article::withCount('likes')
            ->where('en_ligne', true)
            ->orderBy('likes_count', 'desc')
            ->limit(3)
            ->get();
    }

    // Afficher un article spécifique
    public function show(string $id){
        $article = Article::with([
            'editeur',
            'avis.user',
            'likes',
            'accessibilite',
            'conclusion',
            'rythme'
        ])->findOrFail($id);
        
        // Incrémenter le nombre de vues
        $article->increment('nb_vues');
        
        return view('articles.show', compact('article'));
    }
    
    // Gérer les likes/dislikes sur un article
    public function like(string $id, Request $request)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();
        $nature = $request->input('nature'); // 'like' ou 'dislike'
        
        // Vérifier que la nature est valide
        if (!in_array($nature, ['like', 'dislike'])) {
            return back()->with('error', 'Action invalide');
        }
        
        // Vérifier si l'utilisateur a déjà réagi
        $existingLike = $article->likes()->where('user_id', $user->id)->first();
        
        if ($existingLike) {
            // Si l'utilisateur a déjà réagi avec la même nature, on supprime la réaction
            if ($existingLike->pivot->nature === $nature) {
                $article->likes()->detach($user->id);
                return back()->with('success', 'Votre réaction a été supprimée');
            }
            // Sinon, on met à jour la nature de la réaction
            else {
                $article->likes()->updateExistingPivot($user->id, ['nature' => $nature]);
                return back()->with('success', 'Votre réaction a été mise à jour');
            }
        }
        
        // Sinon, on ajoute une nouvelle réaction
        $article->likes()->attach($user->id, ['nature' => $nature]);
        
        return back()->with('success', 'Votre réaction a été enregistrée');
    }

    // Gérer les likes/dislikes
    public function toggleLike(Request $request, string $articleId)
    {
        try {
            // Vérifier que l'utilisateur est connecté
            if (!auth()->check()) {
                return response()->json(['error' => 'Vous devez être connecté pour aimer un article'], 401);
            }

            $user = auth()->user();
            $article = Article::findOrFail($articleId);
            $nature = $request->input('nature'); // 'like' ou 'dislike'

            // Vérifier que la nature est valide
            if (!in_array($nature, ['like', 'dislike'])) {
                return response()->json(['error' => 'Nature invalide'], 400);
            }

            // Convertir en booléen (true pour like, false pour dislike)
            $natureValue = $nature === 'like' ? true : false;

            // Vérifier si l'utilisateur a déjà aimé cet article
            $existingLike = $user->likes()->where('article_id', $articleId)->first();

            if ($existingLike) {
                // Si le like existe déjà avec la même nature, le supprimer (toggle)
                if ($existingLike->pivot->nature == $natureValue) {
                    $user->likes()->detach($articleId);
                    return redirect()->back()->with('success', 'Votre réaction a été supprimée');
                } else {
                    // Si la nature est différente, mettre à jour
                    $user->likes()->updateExistingPivot($articleId, ['nature' => $natureValue]);
                    return redirect()->back()->with('success', 'Votre réaction a été mise à jour');
                }
            } else {
                // Créer un nouveau like
                $user->likes()->attach($articleId, ['nature' => $natureValue]);
                return redirect()->back()->with('success', 'Votre réaction a été enregistrée');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    // Afficher le formulaire de création d'article
    public function create()
    {
        $rythmes = Rythme::all();
        $accessibilites = Accessibilite::all();
        $conclusions = Conclusion::all();

        return view('articles.create', compact('rythmes', 'accessibilites', 'conclusions'));
    }

    // Stocker un nouvel article
    public function store(Request $request)
    {
        $isPublish = $request->has('action') && $request->action === 'publish';
        
        // Validation différente selon l'action
        if ($isPublish) {
            // Validation complète pour la publication
            $request->validate([
                'titre' => 'required|string|max:255',
                'resume' => 'required|string',
                'texte' => 'required|string',
                'image' => 'required|image|max:2048',
                'media' => 'required|mimes:mp3,wav|max:10240',
                'rythme_id' => 'required|exists:rythmes,id',
                'accessibilite_id' => 'required|exists:accessibilites,id',
                'conclusion_id' => 'required|exists:conclusions,id',
            ]);
        } else {
            // Validation minimale pour le brouillon (seul le titre est obligatoire)
            $request->validate([
                'titre' => 'required|string|max:255',
            ], [
                'titre.required' => 'Le titre est obligatoire même pour un brouillon.',
            ]);
        }

        // Gestion des fichiers uniquement s'ils sont fournis
        $imagePath = null;
        $mediaPath = null;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles/images', 'public');
        }
        
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('articles/media', 'public');
        }

        $article = Article::create([
            'titre' => $request->titre,
            'resume' => $request->resume ?? null,
            'texte' => $request->texte ?? null,
            'image' => $imagePath ?? null,
            'media' => $mediaPath ?? null,
            'user_id' => Auth::id(),
            'rythme_id' => $request->rythme_id ?? null,
            'accessibilite_id' => $request->accessibilite_id ?? null,
            'conclusion_id' => $request->conclusion_id ?? null,
            'en_ligne' => $isPublish, // true si publication, false si brouillon
        ]);

        $message = $isPublish ? 'Article publié avec succès !' : 'Brouillon enregistré avec succès !';
        
        // Envoyer des notifications aux suiveurs uniquement si l'article est publié (en_ligne = true)
        if ($isPublish) {
            $suiveurs = $article->editeur->suiveurs;
            
            foreach ($suiveurs as $suiveur) {
                try {
                    $suiveur->notify(new NewArticleFromFollowedUser($article));
                } catch (\Exception $e) {
                    // Log l'erreur mais ne bloque pas le processus
                    \Log::error('Erreur lors de l\'envoi de notification à ' . $suiveur->id . ': ' . $e->getMessage());
                }
            }
        }
        
        return redirect()->route('articles.show', $article->id)
            ->with('success', $message);
    }

    /**
     * Filtrer les articles par accessibilité
     */
    public function byAccessibilite(Accessibilite $accessibilite) {
        $query = Article::with(['editeur', 'accessibilite', 'rythme', 'conclusion'])
            ->where('accessibilite_id', $accessibilite->id)
            ->where('en_ligne', true);
        
        // Si l'utilisateur est connecté, on ajoute ses articles même hors ligne
        if (auth()->check()) {
            $userId = auth()->id();
            $query->orWhere(function($q) use ($userId, $accessibilite) {
                $q->where('user_id', $userId)
                  ->where('accessibilite_id', $accessibilite->id);
            });
        }
        
        $articles = $query->paginate(6);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $accessibilite,
            'type' => 'accessibilite'
        ]);
    }

    /**
     * Filtrer les articles par rythme
     */
    public function byRythme(Rythme $rythme) {
        $query = Article::with(['editeur', 'accessibilite', 'rythme', 'conclusion'])
            ->where('rythme_id', $rythme->id)
            ->where('en_ligne', true);
        
        // Si l'utilisateur est connecté, on ajoute ses articles même hors ligne
        if (auth()->check()) {
            $userId = auth()->id();
            $query->orWhere(function($q) use ($userId, $rythme) {
                $q->where('user_id', $userId)
                  ->where('rythme_id', $rythme->id);
            });
        }
        
        $articles = $query->paginate(6);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $rythme,
            'type' => 'rythme'
        ]);
    }

    /**
     * Filtrer les articles par conclusion
     */
    public function byConclusion(Conclusion $conclusion) {
        $query = Article::with(['editeur', 'accessibilite', 'rythme', 'conclusion'])
            ->where('conclusion_id', $conclusion->id)
            ->where('en_ligne', true);
        
        // Si l'utilisateur est connecté, on ajoute ses articles même hors ligne
        if (auth()->check()) {
            $userId = auth()->id();
            $query->orWhere(function($q) use ($userId, $conclusion) {
                $q->where('user_id', $userId)
                  ->where('conclusion_id', $conclusion->id);
            });
        }
        
        $articles = $query->paginate(6);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $conclusion,
            'type' => 'conclusion'
        ]);
    }

    /**
     * Afficher le formulaire d'édition d'un article
     */
    public function edit(Article $article)
    {
        // Vérifier que l'utilisateur est le propriétaire de l'article
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $rythmes = Rythme::all();
        $accessibilites = Accessibilite::all();
        $conclusions = Conclusion::all();

        return view('articles.edit', compact('article', 'rythmes', 'accessibilites', 'conclusions'));
    }

    /**
     * Mettre à jour un article
     */
    public function update(Request $request, Article $article)
    {
        // Vérifier que l'utilisateur est le propriétaire de l'article
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $isPublish = $request->has('action') && $request->action === 'publish';

        // Validation différente selon l'action
        if ($isPublish) {
            // Validation complète pour la publication
            $request->validate([
                'titre' => 'required|string|max:255',
                'resume' => 'required|string',
                'texte' => 'required|string',
                'image' => 'nullable|image|max:2048',
                'media' => 'nullable|mimes:mp3,wav|max:10240',
                'rythme_id' => 'required|exists:rythmes,id',
                'accessibilite_id' => 'required|exists:accessibilites,id',
                'conclusion_id' => 'required|exists:conclusions,id',
            ]);
        } else {
            // Validation minimale pour le brouillon
            $request->validate([
                'titre' => 'required|string|max:255',
            ]);
        }

        $data = [
            'titre' => $request->titre,
            'resume' => $request->resume ?? $article->resume,
            'texte' => $request->texte ?? $article->texte,
            'rythme_id' => $request->rythme_id ?? $article->rythme_id,
            'accessibilite_id' => $request->accessibilite_id ?? $article->accessibilite_id,
            'conclusion_id' => $request->conclusion_id ?? $article->conclusion_id,
            'en_ligne' => $isPublish,
        ];

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($article->image && Storage::exists('public/' . $article->image)) {
                Storage::delete('public/' . $article->image);
            }
            $data['image'] = $request->file('image')->store('articles/images', 'public');
        }

        // Gestion du média
        if ($request->hasFile('media')) {
            // Supprimer l'ancien média s'il existe
            if ($article->media && Storage::exists('public/' . $article->media)) {
                Storage::delete('public/' . $article->media);
            }
            $data['media'] = $request->file('media')->store('articles/media', 'public');
        }

        $article->update($data);

        $message = $isPublish ? 'Article publié avec succès !' : 'Brouillon mis à jour avec succès !';

        return redirect()->route('articles.show', $article->id)
            ->with('success', $message);
    }

    /**
     * Supprimer un article
     */
    public function destroy(Article $article)
    {
        // Vérifier que l'utilisateur est le propriétaire de l'article
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        // Supprimer l'image et le média
        if ($article->image && Storage::exists('public/' . $article->image)) {
            Storage::delete('public/' . $article->image);
        }
        if ($article->media && Storage::exists('public/' . $article->media)) {
            Storage::delete('public/' . $article->media);
        }

        $article->delete();

        return redirect()->route('user.me')
            ->with('success', 'Article supprimé avec succès !');
    }
}

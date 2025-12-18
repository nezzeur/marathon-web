<?php

namespace App\Http\Controllers;

use App\Models\Accessibilite;
use App\Models\Article;
use App\Models\Conclusion;
use App\Models\Rythme;
use App\Services\Article\ArticleService;
use App\Services\Article\LikeService;
use App\Services\Article\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $articleService;
    protected $likeService;
    protected $notificationService;

    public function __construct(
        ArticleService $articleService,
        LikeService $likeService,
        NotificationService $notificationService
    ) {
        $this->articleService = $articleService;
        $this->likeService = $likeService;
        $this->notificationService = $notificationService;
    }

    /**
     * Page d'accueil : affiche les articles (derniers publiés)
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = auth()->check() ? auth()->id() : null;
        $query = $this->articleService->getArticlesQuery($userId);
        
        $articles = $query->inRandomOrder()->limit(6)->get();
        $articlesPlusVus = $this->articleService->getMostViewedArticles();
        $articlesPlusLikes = $this->articleService->getMostLikedArticles();
        
        // Créer la réponse avec la vue
        return view('home', compact('articles', 'articlesPlusVus', 'articlesPlusLikes'));
    }

    /**
     * Afficher tous les articles avec la barre de recherche
     *
     * @return \Illuminate\View\View
     */
    public function indexAll()
    {
        // Récupérer tous les articles avec pagination
        $articles = Article::with(['editeur', 'accessibilite', 'conclusion', 'rythme'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(9);
        
        // Récupérer les données pour les filtres
        $accessibilites = Accessibilite::all();
        $conclusions = Conclusion::all();
        $rythmes = Rythme::all();
        
        return view('articles.index', compact('articles', 'accessibilites', 'conclusions', 'rythmes'));
    }

    /**
     * Afficher un article spécifique
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $article = Article::with([
            'editeur',
            'avis.user',
            'likes',
            'accessibilite',
            'conclusion',
            'rythme'
        ])->findOrFail($id);
        
        $article->increment('nb_vues');
        
        return view('articles.show', compact('article'));
    }
    
    /**
     * Gérer les likes/dislikes sur un article
     * 
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like(string $id, Request $request)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();
        $nature = $request->input('nature');
        
        $result = $this->likeService->handleLike($article, $user, $nature);
        
        if (isset($result['error'])) {
            return back()->with('error', $result['message']);
        }
        
        return back()->with('success', $result['message']);
    }

    /**
     * Gérer les likes/dislikes (version toggle)
     * 
     * @param Request $request
     * @param string $articleId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function toggleLike(Request $request, string $articleId)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['error' => 'Vous devez être connecté pour aimer un article'], 401);
            }

            $user = auth()->user();
            $article = Article::findOrFail($articleId);
            $nature = $request->input('nature');
            
            $result = $this->likeService->toggleLike($article, $user, $nature);
            
            if (isset($result['error'])) {
                return response()->json(['error' => $result['message']], $result['code'] ?? 400);
            }
            
            return redirect()->back()->with('success', $result['message']);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Afficher le formulaire de création d'article
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $rythmes = Rythme::all();
        $accessibilites = Accessibilite::all();
        $conclusions = Conclusion::all();

        return view('articles.create', compact('rythmes', 'accessibilites', 'conclusions'));
    }

    /**
     * Stocker un nouvel article
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $isPublish = $request->has('action') && $request->action === 'publish';
        
        // Validation différente selon l'action
        $this->validateRequest($request, $isPublish, false);
        
        // Gestion des fichiers
        $imagePath = $this->articleService->handleFileUpload(
            $request->file('image'),
            'articles/images'
        );
        
        $mediaPath = $this->articleService->handleFileUpload(
            $request->file('media'),
            'articles/media'
        );
        
        $article = Article::create([
            'titre' => $request->titre,
            'resume' => $request->resume ?? '',
            'texte' => $request->texte ?? '',
            'image' => $imagePath ?? '',
            'media' => $mediaPath ?? '',
            'user_id' => Auth::id(),
            'rythme_id' => $request->rythme_id ?? null,
            'accessibilite_id' => $request->accessibilite_id ?? null,
            'conclusion_id' => $request->conclusion_id ?? null,
            'en_ligne' => $isPublish,
        ]);
        
        // Envoyer des notifications aux suiveurs si publication
        if ($isPublish) {
            $this->notificationService->notifyFollowers($article);
        }
        
        $message = $isPublish ? 'Article publié avec succès !' : 'Brouillon enregistré avec succès !';
        
        return redirect()->route('articles.show', $article->id)
            ->with('success', $message);
    }
    
    /**
     * Valide la requête selon le type d'action
     * 
     * @param Request $request
     * @param bool $isPublish
     * @param bool $isUpdate
     * @return void
     */
    protected function validateRequest(Request $request, bool $isPublish, bool $isUpdate = false): void
    {
        if ($isPublish) {
            $request->validate([
                'titre' => 'required|string|max:255',
                'resume' => 'required|string',
                'texte' => 'required|string',
                'image' => $isUpdate ? 'nullable|image|max:2048' : 'required|image|max:2048',
                'media' => $isUpdate ? 'nullable|mimes:mp3,wav|max:10240' : 'required|mimes:mp3,wav|max:10240',
                'rythme_id' => 'required|exists:rythmes,id',
                'accessibilite_id' => 'required|exists:accessibilites,id',
                'conclusion_id' => 'required|exists:conclusions,id',
            ]);
        } else {
            $request->validate([
                'titre' => 'required|string|max:255',
            ], [
                'titre.required' => 'Le titre est obligatoire même pour un brouillon.',
            ]);
        }
    }

    /**
     * Filtrer les articles par accessibilité
     * 
     * @param Accessibilite $accessibilite
     * @return \Illuminate\View\View
     */
    public function byAccessibilite(Accessibilite $accessibilite)
    {
        $userId = auth()->check() ? auth()->id() : null;
        $articles = $this->articleService->filterByCharacteristic($accessibilite, 'accessibilite', $userId);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $accessibilite,
            'type' => 'accessibilite'
        ]);
    }

    /**
     * Filtrer les articles par rythme
     * 
     * @param Rythme $rythme
     * @return \Illuminate\View\View
     */
    public function byRythme(Rythme $rythme)
    {
        $userId = auth()->check() ? auth()->id() : null;
        $articles = $this->articleService->filterByCharacteristic($rythme, 'rythme', $userId);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $rythme,
            'type' => 'rythme'
        ]);
    }

    /**
     * Filtrer les articles par conclusion
     * 
     * @param Conclusion $conclusion
     * @return \Illuminate\View\View
     */
    public function byConclusion(Conclusion $conclusion)
    {
        $userId = auth()->check() ? auth()->id() : null;
        $articles = $this->articleService->filterByCharacteristic($conclusion, 'conclusion', $userId);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $conclusion,
            'type' => 'conclusion'
        ]);
    }

    /**
     * Afficher le formulaire d'édition d'un article
     * 
     * @param Article $article
     * @return \Illuminate\View\View
     */
    public function edit(Article $article)
    {
        $this->checkArticleOwnership($article);

        $rythmes = Rythme::all();
        $accessibilites = Accessibilite::all();
        $conclusions = Conclusion::all();

        return view('articles.edit', compact('article', 'rythmes', 'accessibilites', 'conclusions'));
    }

    /**
     * Mettre à jour un article
     * 
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Article $article)
    {
        $this->checkArticleOwnership($article);

        $isPublish = $request->has('action') && $request->action === 'publish';
        $this->validateRequest($request, $isPublish, true);

        $data = $this->prepareArticleData($request, $article);
        
        // Gestion des fichiers
        $data['image'] = $this->articleService->handleFileUpload(
            $request->file('image'),
            'articles/images',
            $article->image
        ) ?? $article->image;
        
        $data['media'] = $this->articleService->handleFileUpload(
            $request->file('media'),
            'articles/media',
            $article->media
        ) ?? $article->media;

        $article->update($data);

        $message = $isPublish ? 'Article publié avec succès !' : 'Brouillon mis à jour avec succès !';

        return redirect()->route('articles.show', $article->id)
            ->with('success', $message);
    }
    
    /**
     * Vérifie que l'utilisateur est propriétaire de l'article
     * 
     * @param Article $article
     * @return void
     */
    protected function checkArticleOwnership(Article $article): void
    {
        if (!$this->articleService->isArticleOwner($article, Auth::id())) {
            abort(403, 'Non autorisé');
        }
    }
    
    /**
     * Prépare les données pour la mise à jour d'un article
     * 
     * @param Request $request
     * @param Article $article
     * @return array
     */
    protected function prepareArticleData(Request $request, Article $article): array
    {
        return [
            'titre' => $request->titre,
            'resume' => $request->resume ?? $article->resume ?? '',
            'texte' => $request->texte ?? $article->texte ?? '',
            'rythme_id' => $request->rythme_id ?? $article->rythme_id ?? null,
            'accessibilite_id' => $request->accessibilite_id ?? $article->accessibilite_id ?? null,
            'conclusion_id' => $request->conclusion_id ?? $article->conclusion_id ?? null,
            'en_ligne' => $request->has('action') && $request->action === 'publish',
        ];
    }
    


    /**
     * Supprimer un article
     * 
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        $this->checkArticleOwnership($article);

        // Supprimer l'image et le média
        $this->articleService->handleFileUpload(null, 'articles/images', $article->image);
        $this->articleService->handleFileUpload(null, 'articles/media', $article->media);

        $article->delete();

        return redirect()->route('user.me')
            ->with('success', 'Article supprimé avec succès !');
    }

    /**
     * Rechercher des articles par différents critères
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = Article::query();
        
        // Recherche par titre
        if ($request->filled('title')) {
            $searchTerm = $request->input('title');
            $query->where(function($q) use ($searchTerm) {
                $q->where('titre', 'like', '%' . $searchTerm . '%')
                  ->orWhere('texte', 'like', '%' . $searchTerm . '%')
                  ->orWhere('resume', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Filtre par accessibilité
        if ($request->filled('accessibilite')) {
            $query->where('accessibilite_id', $request->input('accessibilite'));
        }
        
        // Filtre par conclusion
        if ($request->filled('conclusion')) {
            $query->where('conclusion_id', $request->input('conclusion'));
        }
        
        // Filtre par rythme
        if ($request->filled('rythme')) {
            $query->where('rythme_id', $request->input('rythme'));
        }
        
        // Récupérer les articles filtrés
        $articles = $query->with(['editeur', 'accessibilite', 'conclusion', 'rythme'])->paginate(9);
        
        // Récupérer les données pour les filtres
        $accessibilites = Accessibilite::all();
        $conclusions = Conclusion::all();
        $rythmes = Rythme::all();
        
        return view('articles.search_results', compact('articles', 'accessibilites', 'conclusions', 'rythmes'));
    }
}

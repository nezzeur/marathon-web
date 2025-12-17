<?php

namespace App\Http\Controllers;

use App\Models\Accessibilite;
use App\Models\Article;
use App\Models\Rythme;
use App\Models\Conclusion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // Page d'accueil : affiche les articles (derniers publiés)
    public function index()
    {
        $articles = Article::inRandomOrder()->limit(6)->get();
        return view('welcome', compact('articles'));
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

        $imagePath = $request->file('image')->store('articles/images', 'public');
        $mediaPath = $request->file('media')->store('articles/media', 'public');

        $article = Article::create([
            'titre' => $request->titre,
            'resume' => $request->resume,
            'texte' => $request->texte,
            'image' => $imagePath,
            'media' => $mediaPath,
            'user_id' => Auth::id(),
            'rythme_id' => $request->rythme_id,
            'accessibilite_id' => $request->accessibilite_id,
            'conclusion_id' => $request->conclusion_id,
            'en_ligne' => false,
        ]);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Article créé avec succès !');
    }

    /**
     * Filtrer les articles par accessibilité
     */
    public function byAccessibilite(Accessibilite $accessibilite) {
        $articles = Article::with(['editeur', 'accessibilite', 'rythme', 'conclusion'])
            ->where('accessibilite_id', $accessibilite->id)
            ->paginate(6);
        
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
        $articles = Article::with(['editeur', 'accessibilite', 'rythme', 'conclusion'])
            ->where('rythme_id', $rythme->id)
            ->paginate(6);
        
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
        $articles = Article::with(['editeur', 'accessibilite', 'rythme', 'conclusion'])
            ->where('conclusion_id', $conclusion->id)
            ->paginate(6);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $conclusion,
            'type' => 'conclusion'
        ]);
    }
}

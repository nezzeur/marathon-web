<?php

namespace App\Http\Controllers;

use App\Models\Accessibilite;
use App\Models\Article;
use App\Models\Conclusion;
use App\Models\Rythme;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Page d'accueil : affiche les articles (derniers publiés)
    public function index()
    {
        $articles = Article::inRandomOrder()->limit(6)->get();
        return view('welcome', compact('articles'));
    }
    /**
     * Display the specified resource.
     */
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

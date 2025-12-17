<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
}

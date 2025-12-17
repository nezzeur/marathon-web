<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    // Page d'accueil : affiche les articles (derniers publiés)
    public function index()
    {
        $article = Article::with([
            'editeur',
            'avis.user',
            'likes',
            'accessibilite',
            'conclusion',
            'rythme'
        ])->findOrFail($id);
        $articles = Article::inRandomOrder()->limit(6)->get();
        return view('welcome', compact('articles'));
    }

        return view('articles.show', compact('article'));
    }
}

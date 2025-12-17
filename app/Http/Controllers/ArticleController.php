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
        $query = Article::where('en_ligne', true);
        
        // Si l'utilisateur est connecté, on ajoute ses articles même hors ligne
        if (auth()->check()) {
            $userId = auth()->id();
            $query->orWhere(function($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        
        $articles = $query->inRandomOrder()->limit(6)->get();
        return view('home', compact('articles'));
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Stocke un nouvel avis dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Vérifie que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour laisser un commentaire.');
        }

        // Valide les données du formulaire
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'contenu' => 'required|string|max:1000',
        ]);

        // Crée un nouvel avis associé à l'utilisateur et à l'article
        $avis = new Avis();
        $avis->contenu = $validated['contenu'];
        $avis->user_id = Auth::id();
        $avis->article_id = $validated['article_id'];
        $avis->save();

        // Redirige vers la page de l'article avec un message de succès
        return redirect()->route('articles.show', $validated['article_id'])->with('success', 'Votre commentaire a été publié avec succès !');
    }
}
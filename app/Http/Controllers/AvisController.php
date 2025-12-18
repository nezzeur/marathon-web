<?php

namespace App\Http\Controllers;

use App\Models\Avis;
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

        // Valide les données du formulaire avec des règles de sécurité supplémentaires
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'contenu' => [
                'required',
                'string',
                'max:1000',
                // Ajouter une validation pour bloquer les contenus suspects
                function ($attribute, $value, $fail) {
                    // Bloquer les contenus qui contiennent des balises script
                    if (preg_match('/<script\b[^>]*>/i', $value)) {
                        $fail('Le commentaire contient du code interdit.');
                    }
                    
                    // Bloquer les contenus qui contiennent des attributs dangereux
                    if (preg_match('/on\w+\s*=/i', $value)) {
                        $fail('Le commentaire contient des attributs interdits.');
                    }
                    
                    // Bloquer les contenus qui contiennent des protocoles dangereux
                    if (preg_match('/(javascript|vbscript|data):/i', $value)) {
                        $fail('Le commentaire contient des protocoles interdits.');
                    }
                },
            ],
        ]);

        // Désinfecter le contenu avant de l'enregistrer
        $sanitizer = new \App\Services\Security\TextSanitizer();
        $cleanContent = $sanitizer->sanitize($validated['contenu']);

        // Crée un nouvel avis associé à l'utilisateur et à l'article
        $avis = new Avis();
        $avis->contenu = $cleanContent;
        $avis->user_id = Auth::id();
        $avis->article_id = $validated['article_id'];
        $avis->save();

        // Redirige vers la page de l'article avec un message de succès
        return redirect()->route('articles.show', $validated['article_id'])->with('success', 'Votre commentaire a été publié avec succès !');
    }
}
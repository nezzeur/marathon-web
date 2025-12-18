<?php

namespace App\Services\Validation;

use Illuminate\Http\Request;

class ArticleValidator
{
    /**
     * Valide la requête selon le type d'action
     * 
     * @param Request $request
     * @param bool $isPublish
     * @param bool $isUpdate
     * @return void
     */
    public function validateRequest(Request $request, bool $isPublish, bool $isUpdate = false): void
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
}
<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Models\User;

class LikeService
{
    /**
     * Gère les likes/dislikes sur un article
     * 
     * @param Article $article
     * @param User $user
     * @param string $nature
     * @return array
     */
    public function handleLike(Article $article, User $user, string $nature): array
    {
        // Vérifier que la nature est valide
        if (!in_array($nature, ['like', 'dislike'])) {
            return ['success' => false, 'message' => 'Action invalide', 'error' => true];
        }
        
        // Vérifier si l'utilisateur a déjà réagi
        $existingLike = $article->likes()->where('user_id', $user->id)->first();
        
        if ($existingLike) {
            // Si l'utilisateur a déjà réagi avec la même nature, on supprime la réaction
            if ($existingLike->pivot->nature === $nature) {
                $article->likes()->detach($user->id);
                return ['success' => true, 'message' => 'Votre réaction a été supprimée'];
            }
            // Sinon, on met à jour la nature de la réaction
            else {
                $article->likes()->updateExistingPivot($user->id, ['nature' => $nature]);
                return ['success' => true, 'message' => 'Votre réaction a été mise à jour'];
            }
        }
        
        // Sinon, on ajoute une nouvelle réaction
        $article->likes()->attach($user->id, ['nature' => $nature]);
        
        return ['success' => true, 'message' => 'Votre réaction a été enregistrée'];
    }
    
    /**
     * Gère les likes/dislikes (version toggle)
     * 
     * @param Article $article
     * @param User $user
     * @param string $nature
     * @return array
     */
    public function toggleLike(Article $article, User $user, string $nature): array
    {
        // Vérifier que la nature est valide
        if (!in_array($nature, ['like', 'dislike'])) {
            return ['success' => false, 'message' => 'Nature invalide', 'error' => true, 'code' => 400];
        }
        
        // Convertir en booléen (true pour like, false pour dislike)
        $natureValue = $nature === 'like' ? true : false;
        
        // Vérifier si l'utilisateur a déjà aimé cet article
        $existingLike = $user->likes()->where('article_id', $article->id)->first();
        
        if ($existingLike) {
            // Si le like existe déjà avec la même nature, le supprimer (toggle)
            if ($existingLike->pivot->nature == $natureValue) {
                $user->likes()->detach($article->id);
                return ['success' => true, 'message' => 'Votre réaction a été supprimée'];
            } else {
                // Si la nature est différente, mettre à jour
                $user->likes()->updateExistingPivot($article->id, ['nature' => $natureValue]);
                return ['success' => true, 'message' => 'Votre réaction a été mise à jour'];
            }
        } else {
            // Créer un nouveau like
            $user->likes()->attach($article->id, ['nature' => $natureValue]);
            return ['success' => true, 'message' => 'Votre réaction a été enregistrée'];
        }
    }
}
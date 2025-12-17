<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Notifications\NewArticleFromFollowedUser;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Envoie des notifications aux suiveurs d'un utilisateur
     * 
     * @param Article $article
     * @return void
     */
    public function notifyFollowers(Article $article): void
    {
        $suiveurs = $article->editeur->suiveurs;
        
        foreach ($suiveurs as $suiveur) {
            try {
                $suiveur->notify(new NewArticleFromFollowedUser($article));
            } catch (\Exception $e) {
                // Log l'erreur mais ne bloque pas le processus
                Log::error('Erreur lors de l\'envoi de notification à ' . $suiveur->id . ': ' . $e->getMessage());
            }
        }
    }
}
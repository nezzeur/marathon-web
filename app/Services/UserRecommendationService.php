<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Query\Builder;

class UserRecommendationService
{
    /**
     * Trouver des utilisateurs similaires à un utilisateur donné
     * 
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findSimilarUsers(User $user, int $limit = 5)
    {
        // Ne pas recommander l'utilisateur à lui-même
        $similarUsers = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $user->suivis()->pluck('id')) // Exclure les utilisateurs déjà suivis
            ->whereNotIn('id', $user->suiveurs()->pluck('id')) // Exclure les utilisateurs qui nous suivent déjà
            ->orderByRaw(
                '(
                    -- Similarité basée sur les centres d\'intérêt (articles aimés)
                    (SELECT COUNT(*) FROM likes l1 WHERE l1.user_id = users.id AND l1.article_id IN (
                        SELECT l2.article_id FROM likes l2 WHERE l2.user_id = ?
                    )) * 3 +
                    
                    -- Similarité basée sur les catégories d\'articles créés
                    (SELECT COUNT(*) FROM articles a1 WHERE a1.user_id = users.id AND a1.accessibilite_id IN (
                        SELECT a2.accessibilite_id FROM articles a2 WHERE a2.user_id = ?
                    )) * 2 +
                    
                    -- Similarité basée sur les conclusions d\'articles créés
                    (SELECT COUNT(*) FROM articles a1 WHERE a1.user_id = users.id AND a1.conclusion_id IN (
                        SELECT a2.conclusion_id FROM articles a2 WHERE a2.user_id = ?
                    )) * 2 +
                    
                    -- Similarité basée sur les rythmes d\'articles créés
                    (SELECT COUNT(*) FROM articles a1 WHERE a1.user_id = users.id AND a1.rythme_id IN (
                        SELECT a2.rythme_id FROM articles a2 WHERE a2.user_id = ?
                    )) * 2
                ) DESC',
                [$user->id, $user->id, $user->id, $user->id]
            )
            ->limit($limit)
            ->get();
        
        return $similarUsers;
    }
    
    /**
     * Trouver des utilisateurs populaires (fallback si pas assez de similarités)
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findPopularUsers(int $limit = 5)
    {
        return User::withCount(['articles', 'suiveurs', 'suivis'])
            ->orderBy('suiveurs_count', 'desc')
            ->orderBy('articles_count', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Trouver des utilisateurs recommandés pour un utilisateur donné
     * 
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecommendedUsers(User $user, int $limit = 5)
    {
        $similarUsers = $this->findSimilarUsers($user, $limit);
        
        // Si on n'a pas assez d'utilisateurs similaires, compléter avec des utilisateurs populaires
        if ($similarUsers->count() < $limit) {
            $needed = $limit - $similarUsers->count();
            $popularUsers = $this->findPopularUsers($needed);
            
            // Filtrer les utilisateurs populaires pour exclure ceux déjà dans les similaires
            $popularUsers = $popularUsers->filter(function($popularUser) use ($similarUsers, $user) {
                return !$similarUsers->contains($popularUser) && 
                       $popularUser->id != $user->id &&
                       !$user->suivis->contains($popularUser) &&
                       !$user->suiveurs->contains($popularUser);
            });
            
            $similarUsers = $similarUsers->merge($popularUsers);
        }
        
        return $similarUsers->take($limit);
    }
    
    /**
     * Calculer un score de similarité entre deux utilisateurs (0-100)
     * 
     * @param User $user1
     * @param User $user2
     * @return float
     */
    public function calculateSimilarityScore(User $user1, User $user2): float
    {
        if ($user1->id === $user2->id) {
            return 100.0;
        }
        
        $score = 0.0;
        
        // Similarité basée sur les articles aimés
        $commonLikes = $user1->likes()->whereIn('article_id', $user2->likes()->pluck('article_id'))->count();
        $score += min(30.0, $commonLikes * 5.0); // Max 30 points
        
        // Similarité basée sur les catégories d'articles
        $commonAccessibilite = $user1->articles()->whereIn('accessibilite_id', $user2->articles()->pluck('accessibilite_id'))->count();
        $score += min(20.0, $commonAccessibilite * 3.0); // Max 20 points
        
        // Similarité basée sur les conclusions
        $commonConclusion = $user1->articles()->whereIn('conclusion_id', $user2->articles()->pluck('conclusion_id'))->count();
        $score += min(20.0, $commonConclusion * 3.0); // Max 20 points
        
        // Similarité basée sur les rythmes
        $commonRythme = $user1->articles()->whereIn('rythme_id', $user2->articles()->pluck('rythme_id'))->count();
        $score += min(20.0, $commonRythme * 3.0); // Max 20 points
        
        // Bonus si les deux utilisateurs se suivent mutuellement
        if ($user1->suivis->contains($user2) && $user2->suivis->contains($user1)) {
            $score += 10.0; // Bonus de 10 points pour les amis mutuels
        }
        
        return min(100.0, $score);
    }
}
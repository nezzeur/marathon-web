<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\FileManagement\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Met à jour le profil utilisateur
     * 
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function updateProfile(Request $request, User $user): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar si existe
            if ($user->avatar && \Storage::exists('public/' . $user->avatar)) {
                \Storage::delete('public/' . $user->avatar);
            }
            
            // Télécharger le nouveau avatar avec validation de sécurité
            $validated['avatar'] = $this->fileUploadService->handleFileUpload(
                $request->file('avatar'),
                'avatars',
                $user->avatar,
                ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                ['jpg', 'jpeg', 'png', 'gif', 'webp']
            );
        }

        $user->update($validated);

        return [
            'success' => true,
            'message' => 'Profil mis à jour avec succès !'
        ];
    }

    /**
     * Basculer le suivi d'un utilisateur
     * 
     * @param int $userId
     * @return array
     */
    public function toggleFollow(int $userId): array
    {
        $userToFollow = User::findOrFail($userId);
        $currentUser = Auth::user();

        // Vérifier que l'utilisateur ne tente pas de se suivre lui-même
        if ($currentUser->id === $userToFollow->id) {
            return [
                'success' => false,
                'message' => 'Vous ne pouvez pas vous suivre vous-même.',
                'code' => 400
            ];
        }

        // Vérifier si l'utilisateur est déjà suivi
        $isFollowing = $currentUser->suivis()->where('suivi_id', $userId)->exists();

        if ($isFollowing) {
            // Ne plus suivre
            $currentUser->suivis()->detach($userId);
            $message = 'Vous ne suivez plus ' . $userToFollow->name;
            $action = 'unfollow';
        } else {
            // Suivre
            $currentUser->suivis()->attach($userId);
            $message = 'Vous suivez maintenant ' . $userToFollow->name;
            $action = 'follow';
        }

        // Retourner le nombre de suiveurs mis à jour
        $followersCount = $userToFollow->suiveurs()->count();

        return [
            'success' => true,
            'message' => $message,
            'action' => $action,
            'isFollowing' => !$isFollowing,
            'followersCount' => $followersCount
        ];
    }

    /**
     * Récupère les données du profil personnel
     * 
     * @param User $user
     * @return array
     */
    public function getPersonalProfileData(User $user): array
    {
        // Charger les relations
        $user->load(['articles', 'suiveurs', 'suivis', 'likes']);

        // Séparer les articles en brouillon et publiés
        $articlesBrouillons = $user->articles->where('en_ligne', 0);
        $articlesPublies = $user->articles->where('en_ligne', 1);

        // Articles aimés
        $articlesAimes = $user->likes;

        return [
            'user' => $user,
            'articlesBrouillons' => $articlesBrouillons,
            'articlesPublies' => $articlesPublies,
            'articlesAimes' => $articlesAimes
        ];
    }

    /**
     * Récupère les données du profil public
     * 
     * @param int $userId
     * @return array
     */
    public function getPublicProfileData(int $userId): array
    {
        $user = User::with(['articles' => function($query) {
            $query->where('en_ligne', 1); // Afficher seulement les articles publiés
        }, 'suiveurs', 'suivis'])->findOrFail($userId);

        return [
            'user' => $user
        ];
    }
}
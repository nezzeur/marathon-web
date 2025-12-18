<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Afficher la page personnelle de l'utilisateur connecté
    public function me()
    {
        $user = Auth::user();

        // Charger les relations
        $user->load(['articles', 'suiveurs', 'suivis', 'likes']);

        // Séparer les articles en brouillon et publiés
        $articlesBrouillons = $user->articles->where('en_ligne', 0);
        $articlesPublies = $user->articles->where('en_ligne', 1);

        // Articles aimés
        $articlesAimes = $user->likes;

        return view('users.profile-perso', compact('user', 'articlesBrouillons', 'articlesPublies', 'articlesAimes'));
    }

    // Afficher le profil public d'un utilisateur
    public function show($id)
    {
        $user = User::with(['articles' => function($query) {
            $query->where('en_ligne', 1); // Afficher seulement les articles publiés
        }, 'suiveurs', 'suivis'])->findOrFail($id);

        return view('users.profile', compact('user'));
    }

    // Formulaire d'édition du profil
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit-profile', compact('user'));
    }

    // Mettre à jour le profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Utiliser le service ArticleService pour une validation sécurisée
            $articleService = new \App\Services\Article\ArticleService();
            
            // Supprimer l'ancien avatar si existe
            if ($user->avatar && \Storage::exists('public/' . $user->avatar)) {
                \Storage::delete('public/' . $user->avatar);
            }
            
            // Télécharger le nouveau avatar avec validation de sécurité
            $validated['avatar'] = $articleService->handleFileUpload(
                $request->file('avatar'),
                'avatars',
                $user->avatar,
                ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                ['jpg', 'jpeg', 'png', 'gif', 'webp']
            );
        }

        $user->update($validated);

        return redirect()->route('user.me')->with('success', 'Profil mis à jour avec succès !');
    }

    // Basculer le suivi d'un utilisateur
    public function toggleFollow($userId)
    {
        $userToFollow = User::findOrFail($userId);
        $currentUser = Auth::user();

        // Vérifier que l'utilisateur ne tente pas de se suivre lui-même
        if ($currentUser->id === $userToFollow->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas vous suivre vous-même.'
            ], 400);
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

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'isFollowing' => !$isFollowing,
            'followersCount' => $followersCount
        ]);
    }
}
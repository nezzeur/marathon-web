<?php

namespace App\Http\Controllers;

use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Afficher la page personnelle de l'utilisateur connecté
    public function me()
    {
        $user = Auth::user();
        $profileData = $this->userService->getPersonalProfileData($user);

        return view('users.profile-perso', $profileData);
    }

    // Afficher le profil public d'un utilisateur
    public function show($id)
    {
        $profileData = $this->userService->getPublicProfileData($id);

        return view('users.profile', $profileData);
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
        $result = $this->userService->updateProfile($request, $user);

        return redirect()->route('user.me')->with('success', $result['message']);
    }

    // Basculer le suivi d'un utilisateur
    public function toggleFollow($userId)
    {
        $result = $this->userService->toggleFollow($userId);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], $result['code'] ?? 400);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            'action' => $result['action'],
            'isFollowing' => $result['isFollowing'],
            'followersCount' => $result['followersCount']
        ]);
    }
}
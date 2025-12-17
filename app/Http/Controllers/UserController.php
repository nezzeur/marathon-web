<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        $user = User::with(['articles', 'suiveurs', 'suivis'])->findOrFail(Auth::id());

        $articlesPublies = $user->articles->where('en_ligne', 1);
        $articlesBrouillons = $user->articles->where('en_ligne', 0);

        return view('users.profile-perso', compact('user', 'articlesPublies', 'articlesBrouillons'));
    }
}
<?php

use App\Http\Controllers\ArticleController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::get('/', [ArticleController::class, 'index'])->name("accueil");

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name("articles.show");

Route::get('/contact', function () {
    return view('contact');
})->name("contact");

Route::get('/test-vite', function () {
    return view('test-vite');
})->name("test-vite");

Route::get('/home', function () {
    return view('home');
})->name("home");




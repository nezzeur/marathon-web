<?php

use App\Http\Controllers\ArticleController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::get('/', [ArticleController::class, 'index'])->name("accueil");

Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name("articles.show");

// Routes pour filtrer les articles par caractéristique
Route::get('/articles/accessibilite/{accessibilite}', [ArticleController::class, 'byAccessibilite'])->name("articles.byAccessibilite");
Route::get('/articles/rythme/{rythme}', [ArticleController::class, 'byRythme'])->name("articles.byRythme");
Route::get('/articles/conclusion/{conclusion}', [ArticleController::class, 'byConclusion'])->name("articles.byConclusion");

Route::get('/contact', function () {
    return view('contact');
})->name("contact");

Route::get('/test-vite', function () {
    return view('test-vite');
})->name("test-vite");

Route::get('/home', function () {
    return view('home');
})->name("home");




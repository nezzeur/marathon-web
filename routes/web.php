<?php

use App\Http\Controllers\ArticleController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', [ArticleController::class, 'index'])->name("accueil");

Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name("articles.show");
Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->middleware('auth')->name('articles.edit');
Route::put('/articles/{article}', [ArticleController::class, 'update'])->middleware('auth')->name('articles.update');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->middleware('auth')->name('articles.destroy');

// Routes pour filtrer les articles par caractéristique
Route::get('/articles/accessibilite/{accessibilite}', [ArticleController::class, 'byAccessibilite'])->name("articles.byAccessibilite");
Route::get('/articles/rythme/{rythme}', [ArticleController::class, 'byRythme'])->name("articles.byRythme");
Route::get('/articles/conclusion/{conclusion}', [ArticleController::class, 'byConclusion'])->name("articles.byConclusion");

// Routes pour les notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'all'])->name('notifications.all');
    Route::get('/notifications/mark-as-read/{notification}', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/destroy-all', [\App\Http\Controllers\NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
});

Route::get('/contact', function () {
    return view('contact');
})->name("contact");

Route::get('/test-vite', function () {
    return view('test-vite');
})->name("test-vite");

Route::get('/home', [ArticleController::class, 'index'])->name("home");


Route::get('/profile/{id}', [UserController::class, 'show'])->name('user.profile');

Route::get('/mon-profil', [UserController::class, 'me'])
    ->middleware('auth')
    ->name('user.me');

Route::get('/mon-profil/edit', [UserController::class, 'edit'])
    ->middleware('auth')
    ->name('user.edit');

Route::put('/mon-profil', [UserController::class, 'update'])
    ->middleware('auth')
    ->name('user.update');

// Routes pour les avis/commentaires
Route::post('/avis', [\App\Http\Controllers\AvisController::class, 'store'])->name('avis.store');


<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * ============================================
 * ROUTES PUBLIQUES
 * ============================================
 */

// Page d'accueil
Route::get('/', [ArticleController::class, 'index'])->name("accueil");

// Page first pour les nouveaux visiteurs
Route::get('/first', function () {
    return view('first');
})->name("first.page");

// Route de recherche d'articles
Route::get('/articles/search', [ArticleController::class, 'search'])->name('articles.search');

// Route temporaire pour debug - à supprimer en production
Route::get('/debug-cookie', function () {
    $hasCookie = request()->hasCookie('okrina_visited');
    $cookieValue = request()->cookie('okrina_visited');
    
    return response()->json([
        'has_okrina_visited_cookie' => $hasCookie,
        'cookie_value' => $cookieValue,
        'all_cookies' => request()->cookie()
    ]);
})->name("debug.cookie");

// Route pour supprimer le cookie - à supprimer en production
Route::get('/clear-cookie', function () {
    return response('Cookie cleared!')->cookie(
        cookie()->forget('okrina_visited')
    );
})->name("clear.cookie");

// Page de contact
Route::get('/contact', function () {
    return view('contact');
})->name("contact");

// Page de test Vite
Route::get('/test-vite', function () {
    return view('test-vite');
})->name("test-vite");

// Redirection home (alias de l'accueil)
Route::get('/home', [ArticleController::class, 'index'])->name("home");

/**
 * ============================================
 * ROUTES ARTICLES
 * ============================================
 */

// Création d'articles (protégée par authentification)
Route::middleware(['auth'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store')->middleware('throttle:api');
});

// Liste des articles (publique)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Affichage et gestion des articles
const ARTICLE_SHOW = '/articles/{article}';

Route::get(ARTICLE_SHOW, [ArticleController::class, 'show'])->name("articles.show");
Route::post(ARTICLE_SHOW . '/toggle-like', [ArticleController::class, 'toggleLike'])->name("articles.toggleLike")->middleware('throttle:likes');

// Routes protégées pour la gestion des articles (nécessitent authentification)
Route::middleware(['auth'])->group(function () {
    Route::get(ARTICLE_SHOW . '/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put(ARTICLE_SHOW, [ArticleController::class, 'update'])->name('articles.update');
    Route::delete(ARTICLE_SHOW, [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// Filtrage des articles par caractéristiques
Route::get('/articles/accessibilite/{accessibilite}', [ArticleController::class, 'byAccessibilite'])->name("articles.byAccessibilite");
Route::get('/articles/rythme/{rythme}', [ArticleController::class, 'byRythme'])->name("articles.byRythme");
Route::get('/articles/conclusion/{conclusion}', [ArticleController::class, 'byConclusion'])->name("articles.byConclusion");

/**
 * ============================================
 * ROUTES UTILISATEURS
 * ============================================
 */

// Profil public d'un utilisateur
Route::get('/profile/{id}', [UserController::class, 'show'])->name('user.profile');

// Routes protégées pour la gestion du profil (nécessitent authentification)
Route::middleware(['auth'])->group(function () {
    Route::post('/profile/{id}/toggle-follow', [UserController::class, 'toggleFollow'])->name('user.toggleFollow');
    
    Route::get('/mon-profil', [UserController::class, 'me'])->name('user.me');
    Route::get('/mon-profil/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/mon-profil', [UserController::class, 'update'])->name('user.update');
});

/**
 * ============================================
 * ROUTES NOTIFICATIONS
 * ============================================
 */

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'all'])->name('notifications.all');
    Route::get('/notifications/mark-as-read/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/destroy-all', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
});

/**
 * ============================================
 * ROUTES AVIS/COMMENTAIRES
 * ============================================
 */

Route::post('/avis', [AvisController::class, 'store'])->name('avis.store')->middleware('throttle:comments');


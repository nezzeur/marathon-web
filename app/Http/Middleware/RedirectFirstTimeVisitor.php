<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware pour rediriger les nouveaux visiteurs vers une page d'accueil spéciale
 * avec une expérience d'iframe, puis les rediriger vers la vraie page d'accueil.
 * 
 * Fonctionnement:
 * - Vérifie la présence du cookie 'okrina_visited' pour déterminer si c'est la première visite
 * - Les nouveaux visiteurs (sans cookie) sont redirigés vers /first
 * - La page /first contient une iframe avec la vraie page d'accueil et une animation
 * - Après l'animation, l'utilisateur est redirigé vers la vraie page d'accueil
 * - Un cookie est posé pour éviter de rediriger les visiteurs suivants
 * 
 * Exclusions:
 * - Les routes d'authentification (login, register, logout, password/*)
 * - Les routes API et assets
 * - Les routes techniques (_debugbar, storage, build)
 */
class RedirectFirstTimeVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si c'est la première visite en vérifiant le cookie ET la session
        $hasCookie = $request->hasCookie('okrina_visited');
        $hasSession = Session::has('okrina_visited');
        $isFirstVisit = !$hasCookie && !$hasSession;
        
        // Log pour debug
        Log::info('RedirectFirstTimeVisitor: ' . $request->path() . 
                 ' - hasCookie: ' . ($hasCookie ? 'true' : 'false') . 
                 ', hasSession: ' . ($hasSession ? 'true' : 'false') . 
                 ', isFirstVisit: ' . ($isFirstVisit ? 'true' : 'false'));
        
        // Si nous sommes sur la page d'accueil
        if ($request->is('/')) {
            if ($isFirstVisit) {
                // Première visite: rediriger vers /first avec le cookie ET la session
                Log::info('RedirectFirstTimeVisitor: Première visite - redirection vers /first avec cookie et session');
                
                // Marquer dans la session pour plus de fiabilité
                Session::put('okrina_visited', true);
                Session::save();
                
                // Rediriger vers /first avec le cookie
                return redirect()->route('first.page')->cookie(
                    'okrina_visited', 
                    'true', 
                    60 * 24 * 30, // 30 jours
                    '/', // Chemin racine
                    null, // Domaine par défaut
                    false, // HTTPS seulement
                    false, // HttpOnly
                    false, // Raw
                    'lax' // SameSite (plus compatible)
                );
            } else {
                // Visiteur existant: laisser passer vers la page d'accueil
                Log::info('RedirectFirstTimeVisitor: Visiteur existant - accès direct à l\'accueil');
                return $next($request);
            }
        }
        
        // Si nous sommes sur /first et que ce n'est pas une première visite, rediriger vers l'accueil
        if ($request->is('first') && !$isFirstVisit) {
            Log::info('RedirectFirstTimeVisitor: Visiteur existant sur /first - redirection vers home');
            return redirect()->route('home');
        }
        
        // Pour toutes les autres routes, laisser passer
        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Vérifier si c'est la première visite en vérifiant le cookie existant
        if (!$request->hasCookie('okrina_visited')) {
            // Si c'est la première visite et qu'on n'est pas sur une route spécifique (auth, api, etc.)
            // et qu'on n'est pas déjà sur /first, rediriger vers first
            if (!$request->is('first') && 
                !$request->is('login') && 
                !$request->is('register') && 
                !$request->is('logout') &&
                !$request->is('password/*') &&
                !$request->is('auth/*') &&
                !$request->is('api/*') &&
                !$request->is('_debugbar/*') &&
                !$request->is('storage/*') &&
                !$request->is('build/*')) {
                
                // Rediriger vers la page first pour les nouveaux visiteurs
                return redirect()->route('first.page');
            }
        } else {
            // Si le cookie existe (visiteur déjà vu) et qu'on est sur /first, rediriger vers l'accueil
            if ($request->is('first')) {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
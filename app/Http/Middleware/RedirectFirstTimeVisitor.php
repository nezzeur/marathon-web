<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
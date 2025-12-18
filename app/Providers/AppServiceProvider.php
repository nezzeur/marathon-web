<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configuration du rate limiting pour la sécurité
        $this->configureRateLimiting();
        
        Fortify::loginView(function () {
            return view('auth.login');
        });
        Fortify::registerView(function () {
            return view('auth.register');
        });
    }

    /**
     * Configure le rate limiting pour protéger contre les attaques par brute force
     */
    protected function configureRateLimiting(): void
    {
        // Limiter les tentatives de connexion à 5 par minute par IP/email
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip());
        });

        // Limiter les tentatives de deux facteurs à 5 par minute
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip());
        });

        // Limiter les créations de compte à 10 par heure par IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perHour(10)->by($request->ip());
        });

        // Limiter les routes API sensibles à 60 requêtes par minute
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Limiter les commentaires à 5 par minute par utilisateur
        RateLimiter::for('comments', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });

        // Limiter les likes à 10 par minute par utilisateur
        RateLimiter::for('likes', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });
    }
}

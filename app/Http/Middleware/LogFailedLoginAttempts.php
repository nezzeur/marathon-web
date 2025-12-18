<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogFailedLoginAttempts
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
        $response = $next($request);
        
        // Vérifier si c'est une tentative de connexion échouée
        if ($request->is('login') && $response->status() === 302) {
            $email = $request->input('email');
            $ip = $request->ip();
            $userAgent = $request->userAgent();
            
            // Journaliser la tentative échouée dans la base de données
            try {
                \App\Models\FailedLoginAttempt::logAttempt($email, $ip, $userAgent);
                
                // Journaliser également dans les logs
                Log::warning('Tentative de connexion échouée', [
                    'email' => $email,
                    'ip' => $ip,
                    'user_agent' => $userAgent,
                    'timestamp' => now()->toDateTimeString()
                ]);
                
                // Vérifier si c'est une attaque potentielle (plusieurs tentatives)
                $this->checkForBruteForceAttack($email, $ip);
            } catch (\Exception $e) {
                Log::error('Erreur lors de la journalisation de la tentative de connexion: ' . $e->getMessage());
            }
        }
        
        return $response;
    }
    
    /**
     * Vérifie si une adresse IP ou email montre des signes d'attaque par brute force
     *
     * @param string|null $email
     * @param string $ip
     * @return void
     */
    protected function checkForBruteForceAttack(?string $email, string $ip): void
    {
        try {
            // Vérifier si l'IP ou email est déjà bloqué
            if (\App\Models\FailedLoginAttempt::isBlocked($email, $ip)) {
                Log::alert('Tentative de connexion depuis une IP/email bloqué', [
                    'email' => $email,
                    'ip' => $ip,
                    'timestamp' => now()->toDateTimeString()
                ]);
                return;
            }
            
            // Compter les tentatives récentes (dernière heure)
            $shouldBlock = \App\Models\FailedLoginAttempt::shouldBlock($email, $ip, 10, 60);
            
            if ($shouldBlock) {
                // Bloquer l'IP/email pour 1 heure
                \App\Models\FailedLoginAttempt::block($email, $ip, 60);
                
                Log::alert('Attaque par brute force détectée - IP/email bloqué', [
                    'email' => $email,
                    'ip' => $ip,
                    'blocked_until' => now()->addHour()->toDateTimeString(),
                    'timestamp' => now()->toDateTimeString()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la vérification du brute force: ' . $e->getMessage());
        }
    }
}
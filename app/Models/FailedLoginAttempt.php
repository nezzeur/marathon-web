<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedLoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'blocked',
        'blocked_until'
    ];

    protected $casts = [
        'blocked' => 'boolean',
        'blocked_until' => 'datetime'
    ];

    /**
     * Enregistre une tentative de connexion échouée
     *
     * @param string|null $email
     * @param string $ipAddress
     * @param string|null $userAgent
     * @return self
     */
    public static function logAttempt(?string $email, string $ipAddress, ?string $userAgent): self
    {
        return self::create([
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'blocked' => false,
            'blocked_until' => null
        ]);
    }

    /**
     * Vérifie si une IP ou email doit être bloqué
     *
     * @param string|null $email
     * @param string $ipAddress
     * @param int $threshold
     * @param int $minutes
     * @return bool
     */
    public static function shouldBlock(?string $email, string $ipAddress, int $threshold = 10, int $minutes = 60): bool
    {
        $attempts = self::where(function($query) use ($email, $ipAddress) {
            if ($email) {
                $query->orWhere('email', $email);
            }
            $query->orWhere('ip_address', $ipAddress);
        })->where('created_at', '>=', now()->subMinutes($minutes))->count();

        return $attempts >= $threshold;
    }

    /**
     * Bloque une IP ou email pour une durée déterminée
     *
     * @param string|null $email
     * @param string $ipAddress
     * @param int $minutes
     * @return int
     */
    public static function block(?string $email, string $ipAddress, int $minutes = 60): int
    {
        return self::where(function($query) use ($email, $ipAddress) {
            if ($email) {
                $query->orWhere('email', $email);
            }
            $query->orWhere('ip_address', $ipAddress);
        })->update([
            'blocked' => true,
            'blocked_until' => now()->addMinutes($minutes)
        ]);
    }

    /**
     * Vérifie si une IP ou email est actuellement bloqué
     *
     * @param string|null $email
     * @param string $ipAddress
     * @return bool
     */
    public static function isBlocked(?string $email, string $ipAddress): bool
    {
        $blocked = self::where(function($query) use ($email, $ipAddress) {
            if ($email) {
                $query->orWhere('email', $email);
            }
            $query->orWhere('ip_address', $ipAddress);
        })->where('blocked', true)
        ->where(function($query) {
            $query->where('blocked_until', '>=', now())->orWhereNull('blocked_until');
        })->exists();

        return $blocked;
    }

    /**
     * Débloque une IP ou email
     *
     * @param string|null $email
     * @param string $ipAddress
     * @return int
     */
    public static function unblock(?string $email, string $ipAddress): int
    {
        return self::where(function($query) use ($email, $ipAddress) {
            if ($email) {
                $query->orWhere('email', $email);
            }
            $query->orWhere('ip_address', $ipAddress);
        })->update([
            'blocked' => false,
            'blocked_until' => null
        ]);
    }

    /**
     * Nettoie les tentatives anciennes (plus de 30 jours)
     *
     * @return int
     */
    public static function cleanupOldAttempts(): int
    {
        return self::where('created_at', '<=', now()->subDays(30))->delete();
    }
}

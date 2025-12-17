<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'user_id');
    }

    public function likes()
    {
        return $this->belongsToMany(Article::class, 'likes')
            ->withPivot('nature');
    }


    public function suiveurs()
    {
        return $this->belongsToMany(User::class, 'suivis', 'suivi_id', 'suiveur_id');
    }

    public function suivis()
    {
        return $this->belongsToMany(User::class, 'suivis', 'suiveur_id', 'suivi_id');
    }
}
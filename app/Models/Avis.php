<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Security\TextSanitizer;

class Avis extends Model
{

    protected $table = 'avis';

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function article() {
        return $this->belongsTo(Article::class);
    }

    /**
     * Retourne le contenu désinfecté
     * 
     * @return string
     */
    public function getSafeContentAttribute()
    {
        $sanitizer = new TextSanitizer();
        return $sanitizer->sanitizeWithLineBreaks($this->contenu ?? '');
    }

}

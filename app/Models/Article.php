<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Security\MarkdownSanitizer;

class Article extends Model
{
    protected $guarded = [];

    public function editeur() {
        return $this->belongsTo(User::class, "user_id");
    }

    public function avis() {
        return $this->hasMany(Avis::class);
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'likes')->withPivot("nature");
    }

    public function accessibilite() {
        return $this->belongsTo(Accessibilite::class);
    }
    

    public function conclusion() {
        return $this->belongsTo(Conclusion::class);
    }

    public function rythme() {
        return $this->belongsTo(Rythme::class);
    }

    public function getTexteHtmlAttribute()
    {
        $sanitizer = new MarkdownSanitizer();
        return $sanitizer->sanitizeAndRender($this->texte ?? '');
    }

    public function getResumeHtmlAttribute()
    {
        $sanitizer = new MarkdownSanitizer();
        return $sanitizer->sanitizeAndRender($this->resume ?? '');
    }

}

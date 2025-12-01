<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{

    protected $table = 'avis';

    protected $protected = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function article() {
        return $this->belongsTo(Article::class);
    }

}

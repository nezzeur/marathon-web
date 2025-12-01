<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    protected  $protected = [];

    public function articles() {
        return $this->hasMany(Article::class);
    }

    //
}

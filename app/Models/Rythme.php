<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rythme extends Model
{
    //
    protected  $protected = [];

    public function articles() {
        return $this->hasMany(Article::class);
    }

}

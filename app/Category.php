<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }

    public function reviews()
    {
        return $this->belongsToMany('App\Review')->withTimestamps();
    }
}

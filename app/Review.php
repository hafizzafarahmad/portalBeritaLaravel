<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Category')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

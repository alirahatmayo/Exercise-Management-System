<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coach extends Model
{
    //
    public $timestamps = false;

        public function user()
    {
        return $this->belongsTo('App\User');
    }

        public function player()
    {
        return $this->hasMany('App\Player');
    }

    public function exercise()
    {
        return $this->belongsToMany('App\Exercise');
    }

        public function post()
    {
        return $this->hasMany('App\Post');
    }
}

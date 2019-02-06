<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exercise extends Model
{
    //
     public function player()
    {
        return $this->belongsToMany('App\Player');
    }

    public function coach()
    {
        return $this->belongsToMany('App\Coach');
    }

        public function post()
    {
        return $this->hasMany('App\Post');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    public function player()
    {
        return $this->belongsTo('App\Player');
    }

        public function coach()
    {
        return $this->belongsTo('App\Coach');
    }
        public function exercise()
    {
        return $this->belongsTo('App\Exercise');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

}

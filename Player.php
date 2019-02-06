<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class player extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'coach_id', 'description',
    ];

    public function coach()
    {
        return $this->belongsTo('App\Coach');
    }

    public function exercise()
    {
        return $this->belongsToMany('App\Exercise');
    }
       public function user()
    {
        return $this->belongsTo('App\User');
    }

/*          public function getCoachName()
      {
        return User:: where ('id', $this->user_id)->first()->name;
      }
*/
        public function post()
    {
        return $this->hasMany('App\Post');
    }
}

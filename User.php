<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role' , 'user_name',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function job()
    {
        //return->$this->belongsTo('App\Job');
    }

        public function coach()
    {
        return $this->hasMany('App\Coach');
    }

    public function player()
    {
        return $this->hasMany('App\Player');
    }

     public function management()
    {
        return $this->hasMany('App\Management');
    }

}

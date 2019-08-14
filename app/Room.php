<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function Messages(){
        return $this->hasMany('App\Message');
    }

    public function User(){
        return $this->belongsTo('App\User');
    }

    public function inRoom(){
        return $this->hasMany('App\inRoom');
    }

}

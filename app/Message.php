<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function Room(){
        return $this->belongsTo('App\Room');
    }
    public function User(){
        return $this->belongsTo('App\User');
    }
}

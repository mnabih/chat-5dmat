<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inRoom extends Model
{
    public function User(){
        return $this->belongsTo('App\User');
    }
    public function Room(){
        return $this->belongsTo('App\Room');
    }
}

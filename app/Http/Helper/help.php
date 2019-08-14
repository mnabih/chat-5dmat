<?php
use Pusher\Laravel\Facades\Pusher;

if(!function_exists('tigger')){
    function tigger($channel,$event,$data){
        Pusher::trigger($channel, $event,  $data);
    }
}


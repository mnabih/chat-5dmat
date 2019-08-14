<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
//use Pusher\Laravel\Facades\Pusher;


class MessagesController extends Controller
{
    public function addMessage(Request $request){
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'message'     => 'required|min:5|max:500',
            'room_id'     => 'required|exists:rooms,id',
        ]);

        /** Send Error Massages **/
        if ($validate->fails()) {
            return response()->json(['status'=> 0,'message' => $validate->errors()->first()]);
        }

        $user = Auth::user();

        /** save new room **/
        $new            = new Message();
        $new->room_id   = $request->room_id;
        $new->user_id   = $user->id;
        $new->text      = $request->message;
        $new->save();
        $message = Message::whereId($new->id)->with('User','Room')->first();

        // emit/trigger to pusher
        $channel = 'room_' . $new->room_id;
        $event = 'new_message';
        tigger($channel, $event,$message);

        return response()->json(['status'=> 1,'message' => 'success','data'=>$message]);
    }
}

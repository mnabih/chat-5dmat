<?php

namespace App\Http\Controllers;

use App\Room;
use App\inRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomsController extends Controller
{
    public function addRoom(Request $request)
    {

        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'name'     => 'required|max:50',
        ]);

        /** Send Error Massages **/
        if ($validate->fails()) {
            return response()->json(['status'=> 0,'message' => $validate->errors()->first()]);
        }

        /** save new room **/
        $new = new Room();
        $new->name = $request->name;
        $new->user_id = Auth::id();
        $new->save();
        return response()->json(['status'=> 1,'message' => 'success']);
    }

    public function getAllRooms(){
        $allRooms = Room::with('user')->get();
        return response()->json(['status' => 1, 'message' =>'success', 'data'=> $allRooms ]);
    }
    public function getMyRooms(){
        $myRooms = Room::where('user_id',Auth::id())->get();
        return response()->json(['status' => 1, 'message' =>'success', 'data'=> $myRooms ]);
    }

    public function deleteMyRoom(Room $room){
       if($room && $room->user_id == Auth::id()){
           $room->delete();
           //$myRooms = Room::where('user_id',Auth::id())->get();
           return response()->json(['status' => 1, 'message' =>'deleted' ]);
       }else{
           return response()->json(['status' => 0, 'message' =>'can`t delete']);
       }

    }


    /** users */
    public function RoomUsers(Room $room){
        //$roomUsers = $room->inRoom;
        $roomUsers = inRoom::where('room_id',$room->id)->with('User')->get();

        // emit/trigger to pusher
        $channel = 'roomUsers_' . $room->id;
        $event = 'room_users';
        tigger($channel, $event,$roomUsers);

        return response()->json(['status' => 1, 'message' =>'success', 'data'=> $roomUsers ]);
    }
    public function addToRoom(Room $room){
        $old = inRoom::where('user_id',Auth::id())->first();
        if($old){
            // delete old and update data to old room
            $old->delete();

            $oldRoom = Room::whereId($old->room_id)->first();
            //$roomUsers = $oldRoom->inRoom;
            $roomUsers = inRoom::where('room_id',$oldRoom->id)->with('User')->get();
            // emit/trigger to pusher for old room update room users
            $channel = 'roomUsers_' . $oldRoom->id;
            $event = 'room_users';
            tigger($channel, $event,$roomUsers);

            // emit/triger to pusher user left room
            $channel = 'userleft_' . $oldRoom->id;
            $event = 'user_left';
            tigger($channel, $event,Auth::user());

            
            $this->NewRoomLogin($room->id);
        }else{
            $this->NewRoomLogin($room->id);
        }
        // emit/triger to pusher user join room
        $channel = 'userjoin_' . $room->id;
        $event = 'user_join';
        tigger($channel, $event,Auth::user());

        return response()->json(['status' => 1, 'message' =>'success', 'data'=> Auth::user() ]);
    }
    protected function NewRoomLogin($room_id){
        $user = Auth::user();
        $new = new inRoom;
        $new->user_id = $user->id;
        $new->room_id = $room_id;
        $new->save();
    }
}

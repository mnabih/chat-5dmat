<?php

namespace App\Http\Controllers;

use App\Room;
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
}

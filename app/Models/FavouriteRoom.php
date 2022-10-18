<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FavouriteRoom extends Model
{
    protected $fillable = ['user_id', 'room_id'];

    public function checkIfFavourited($roomId)
    {
        return FavouriteRoom::where([['room_id', $roomId], ['user_id', auth()->user()->id]])->first();
    }

    public function favouriteRoom($roomId)
    {
        $saved_room = auth()->user()->favouriteRooms()->syncWithoutDetaching($roomId);
        $room = (new Room)->findRoomById($roomId);
        return $room;
    }

    public function deleteFavourite($roomId)
    {
        $saved_room = $this->checkIfFavourited($roomId);
        if (!$saved_room) {
            throw new ModelNotFoundException("favourite item not found");
        }
        auth()->user()->favouriteRooms()->detach($roomId);
        $room = (new Room)->findRoomById($roomId);
        return $room;
    }
}

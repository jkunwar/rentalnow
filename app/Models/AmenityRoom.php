<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenityRoom extends Model
{
    public function deleteRoomAmenities($roomId)
    {
        AmenityRoom::where('room_id', $roomId)->delete();
    }
}

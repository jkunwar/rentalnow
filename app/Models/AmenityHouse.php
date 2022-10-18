<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenityHouse extends Model
{
    public function deleteHouseAmenities($houseId)
    {
        AmenityHouse::where('house_id', $houseId)->delete();
    }
}

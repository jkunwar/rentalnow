<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenity extends Model
{
    use SoftDeletes;

    protected $hidden = ['pivot'];

    public function getAmenities($amenityFor)
    {
        $amenities = Amenity::where('amenity_for', $amenityFor)
            ->orWhere('amenity_for', 'both')->get();
        return $amenities;
    }
}

<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FavouriteHouse extends Model
{
    protected $fillable = ['user_id', 'house_id'];

    public function checkIfFavourited($houseId) {
    	return FavouriteHouse::where([['house_id', $houseId], ['user_id', auth()->user()->id]])->first();
    }

    public function favouriteHouse($houseId) {
        $saved_house = auth()->user()->favouriteHouses()->syncWithoutDetaching($houseId);
        $house = (new House)->findHouseById($houseId);
    	return $house;
    }

    public function deleteFavourite($houseId) {
        $saved_house = $this->checkIfFavourited($houseId);
        if(!$saved_house) {
            throw new ModelNotFoundException("favourite item not found");
        }
       	auth()->user()->favouriteHouses()->detach($houseId);
        $house = (new House)->findHouseById($houseId);
        return $house;
    }
}

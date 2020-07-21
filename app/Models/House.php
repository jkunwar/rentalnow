<?php

namespace App\Models;

use DB;
use App\Models\HouseImage;
use App\Models\AmenityHouse;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class House extends Model
{
    use SoftDeletes;

    protected $hidden = ['pivot'];

    public function user() {
        return $this->belongsTo('App\Models\User')->select('id', 'name', 'gender', 'profile_image');
    }

    public function address() {
        return $this->belongsTo('App\Models\Address');
    }

    public function amenities() {
        return $this->belongsToMany('App\Models\Amenity', 'amenity_houses')->withTimestamps();
    }

    public function images() {
        return $this->hasMany('App\Models\HouseImage')->select('id', 'house_id', 'image_path');
    }

    public function favourites() {
        return $this->hasMany('App\Models\FavouriteHouse');
    }

    public function checkIfHouseExists($houseId) {
        $house = House::where('id', $houseId)->first();
        if(!$house) {
            throw new ModelNotFoundException("house not found");
        }
        
        return $house;
    }

    public function houseQuery() {
        $query = House::join('users', 'users.id', 'houses.user_id')
                ->leftJoin('providers', 'users.id', 'providers.user_id')
                ->join('addresses', 'addresses.id', 'houses.address_id')
                ->select('houses.*', 'users.id as user_id', 'users.name as username', 'users.profile_image','providers.phone_number', 'providers.email', 'addresses.id as address_id', 'addresses.location_id', 'addresses.location', 'addresses.latitude', 'addresses.longitude')
                ->with('amenities')
                ->with('images');

        if(\Auth::guard('api')->check()) {
            $user_id = \Auth::guard('api')->user()->id;
            $query->selectRaw("(SELECT count(*) FROM favourite_houses WHERE favourite_houses.house_id = houses.id AND favourite_houses.user_id = '$user_id') as favourite");
        }else {
            $query->selectRaw("(SELECT 0 as favourite)");
        }    

        return $query;
    }

    public function findHouseById($houseId) {
        $query = $this->houseQuery();
        $house = $query->where('houses.id', $houseId)->first();
        if(!$house) {
            throw new ModelNotFoundException("house not found");
        }

        return $house;
    }

    public function getAll() {
        $sort = Request::get('sort');
        $limit = Request::get('limit') ?: 20;
        $page = Request::get('offset');
        request()->request->add(['page' => $page ?: 1]);
        
        $radius = Request::get('radius');
        $latitude = Request::get('lat');
        $longitude = Request::get('lng');
        $min_price = Request::get('min_price');
        $max_price = Request::get('max_price');
        $amenities = Request::get('amenity');
        $pets_allowed = Request::get('pets_allowed');
        $query = $this->houseQuery();
        
        $query->where('houses.is_available', 1);
        
        if(isset($sort)) {
            if($sort == 'rent_asc') {
                $query->orderBy('houses.rent', 'asc');
            }else if($sort == 'rent_desc') {
                $query->orderBy('houses.rent', 'desc');
            }else if($sort == 'oldest') {
                $query->orderBy('houses.created_at', 'asc');
            }else {
                $query->orderBy('houses.created_at', 'desc');
            }
        }else {
            $query->orderBy('houses.created_at', 'desc');
        }

        if(isset($min_price) && is_numeric($min_price)) {
            $query->where('houses.rent', '>=' , $min_price);
        }
        if(isset($max_price) && is_numeric($max_price)) {
            $query->where('houses.rent', '<=' , $max_price);
        }
        if(isset($pets_allowed)) {
            $query->where('houses.pets_allowed', $pets_allowed);
        }
        if(isset($amenities)) {
            $new_amenities = array();
            foreach ($amenities as $amenity) {
                if($amenity != null || $amenity != 0){
                    array_push($new_amenities, (int)$amenity); 
                }
            }
            if(count($new_amenities) == 1) {
                $query->join('amenity_houses', 'houses.id', 'amenity_houses.house_id')
                    ->join('amenities', 'amenity_houses.amenity_id', 'amenities.id')
                    ->whereIn('amenities.id', $new_amenities);
            }else {
                $query->whereHas('amenities', function ($q) use ($new_amenities) {
                    $q->where(function ($q) use ($new_amenities) {
                        $q->whereIn('amenities.id', $new_amenities);
                    })->select(DB::raw('count(distinct amenities.id)'));
                }, '>=', count($new_amenities));
            }
        }

        if((isset($radius) && is_numeric($radius)) && isset($latitude) && isset($longitude)) {
            $query->WhereRaw("earth_distance(ll_to_earth(".$latitude.", ".$longitude."), ll_to_earth(addresses.latitude, addresses.longitude)) / 1000 <= ".$radius);
        }

        $houses = $query->paginate($limit);

        return $houses;
    }

    public function getUserHouses($userId) {
        $limit = Request::get('limit') ?: 20;
        $page = Request::get('offset');
        request()->request->add(['page' => $page ?: 1]);
        $query = $this->houseQuery();
        $houses = $query->where([['houses.is_available', 1], ['users.id', $userId]])
                        ->orderBy('houses.created_at', 'desc')
                        ->paginate($limit);

        return $houses;
    }

    public function deleteHouse($houseId) {
        $house = $this->checkIfHouseExists($houseId);

        return $house->delete();
    }

    public function getFavouriteHouses() {
        $limit = Request::get('limit') ?: 20;
        $page = Request::get('offset');
        request()->request->add(['page' => $page ?: 1]);

        $query = $this->houseQuery();

        return $query->where('is_available', 1)
            ->join('favourite_houses', 'houses.id', 'favourite_houses.house_id')
            ->where('favourite_houses.user_id', \Auth::guard('api')->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    public function addNewHouse($request, $address) {
        $house = new House;
        $house->title = $request->title;
        $house->user_id = auth()->user()->id;
        $house->address_id = $address->id;
        $house->currency = $request->currency;
        $house->rent = $request->rent;
        if($request->move_date) {
            $house->move_date = $request->move_date;
        }
        if($request->leave_date) {
            $house->leave_date = $request->leave_date;
        }
        $house->description = $request->description;

        // Residence
        $house->bedrooms = $request->bedrooms;
        $house->bathrooms = $request->bathrooms;
        $house->measurement = $request->measurement;
        $house->m_unit = $request->measurement_unit;
        $house->furnished = $request->furnished;
        if($request->pets_allowed) {
            $house->pets_allowed = $request->pets_allowed;
        }
        $house->save();
        if($request->amenities) {
            $house->amenities()->sync($request->amenities);
        }
        $house = $this->findHouseById($house->id);

        return $house;
    }

    public function updateHouse($request, $houseId) {
        $house = $this->checkIfHouseExists($houseId);
        $auth_user = auth()->user()->id;
        if($house->user_id !== $auth_user) {
            throw new ModelNotFoundException("house not found");
        }
        $house->title = $request->title;
        $house->user_id = $auth_user;
        $house->currency = $request->currency;
        $house->rent = $request->rent;
        $house->move_date = $request->move_date;
        if($request->leave_date) {
            $house->leave_date = $request->leave_date;
        }
        $house->description = $request->description;
        $house->bedrooms = $request->bedrooms;
        $house->bathrooms = $request->bathrooms;
        $house->measurement = $request->measurement;
        $house->m_unit = $request->measurement_unit;
        $house->furnished = $request->furnished;
        if($request->is_available) {
            $house->is_available = $request->is_available;
        }
        if($request->pets_allowed) {
            $house->pets_allowed = $request->pets_allowed;
        }
        $house->save();

        if($request->amenities) {
            (new AmenityHouse)->deleteHouseAmenities($house->id);
            $house->amenities()->sync($request->amenities);
        }
        (new HouseImage)->deleteImagesByHouseId($house->id);
        $house = $this->findHouseById($house->id);

        return $house;
    }

    public function markUnavailable($houseId) {
        $house = $this->checkIfHouseExists($houseId);
        $auth_user = auth()->user()->id;
        if($house->user_id !== $auth_user) {
            throw new ModelNotFoundException("house not found");
        }
        $house->is_available = false;
        $house->save();
        $house = $this->findHouseById($house->id);
        return $house;
    }

    public function markAvailable($houseId) {
        $house = $this->checkIfHouseExists($houseId);
        $auth_user = auth()->user()->id;
        if($house->user_id !== $auth_user) {
            throw new ModelNotFoundException("house not found");
        }
        $house->is_available = true;
        $house->save();
        $house = $this->findHouseById($house->id);

        return $house;
    }

    public function houseDataTableQuery() {
        $query = House::join('addresses', 'houses.address_id', 'addresses.id')
                    ->join('users','houses.user_id', 'users.id')
                    ->select('houses.*', 'addresses.location', 'users.name');

        return $query;
    }
}

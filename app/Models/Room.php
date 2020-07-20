<?php

namespace App\Models;

use DB;
use App\Models\RoomImage;
use App\Models\AmenityRoom;
use Illuminate\Support\Facades\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Room extends Model
{
    use SoftDeletes;

    protected $hidden = ['pivot'];

    public function user() {
        return $this->belongsTo('App\Models\User')->select('id', 'name', 'profile_image');
    }

    public function address() {
        return $this->belongsTo('App\Models\Address');
    }

    public function amenities() {
        return $this->belongsToMany('App\Models\Amenity', 'amenity_rooms')->withTimestamps();
    }

    public function images() {
        return $this->hasMany('App\Models\RoomImage')->select('id', 'room_id', 'image_path');
    }

    public function favourites() {
        return $this->hasMany('App\Models\FavouriteRoom');
    }

    public function checkIfRoomExists($roomId) {
        $room = Room::where('id', $roomId)->first();
        if(!$room) {
            throw new ModelNotFoundException("room not found");
        }
        return $room;
    }

    public function roomQuery() {
        $query = Room::join('users', 'rooms.user_id', 'users.id')
                ->leftJoin('providers', 'users.id', 'providers.user_id')
                ->join('addresses', 'rooms.address_id', 'addresses.id')
                ->select('rooms.*', 'users.id as user_id', 'users.name as username', 'users.profile_image','providers.phone_number', 'providers.email', 'addresses.id as address_id', 'addresses.location_id', 'addresses.location', 'addresses.latitude', 'addresses.longitude')
                ->with('amenities')
                ->with('images');

        if(\Auth::guard('api')->check()) {
            $user_id = \Auth::guard('api')->user()->id;
            $query->selectRaw("(SELECT count(*) FROM favourite_rooms WHERE favourite_rooms.room_id = rooms.id AND favourite_rooms.user_id = '$user_id') as favourite");
        }else {
            $query->selectRaw("(SELECT 0 as favourite)");
        }    
        return $query;
    }

    public function findRoomById($roomId) {
        $query = $this->roomQuery();
        $room = $query->where('rooms.id', $roomId)->first();
        if(!$room) {
            throw new ModelNotFoundException("room not found");
        }
        return $room;
    }

    public function getAll() {
        $sort = Room::get('sort');
        $limit = Room::get('limit') ?: 20;
        $page = Room::get('offset');
        request()->request->add(['page' => $page ?: 1]);
        $radius = Room::get('radius') ?: 500;
        $latitude = Room::get('lat');
        $longitude = Room::get('lng');
        $min_price = Room::get('min_price');
        $max_price = Room::get('max_price');
        $amenities = Room::get('amenity');
        $pets_allowed = Room::get('pets_allowed');

        $query = $this->roomQuery();
        
        $query->where('rooms.is_available', 1);
        
        if(isset($sort)) {
            if($sort == 'rent_asc') {
                $query->orderBy('rooms.rent', 'asc');
            }else if($sort == 'rent_desc') {
                $query->orderBy('rooms.rent', 'desc');
            }else if($sort == 'oldest') {
                $query->orderBy('rooms.created_at', 'asc');
            }else {
                $query->orderBy('rooms.created_at', 'desc');
            }
        }else {
            $query->orderBy('rooms.created_at', 'desc');
        }

        if(isset($min_price) && is_numeric($min_price)) {
            $query->where('rooms.rent', '>=' , $min_price);
        }
        if(isset($max_price) && is_numeric($max_price)) {
            $query->where('rooms.rent', '<=' , $max_price);
        }

        if(isset($pets_allowed)) {
            $query->where('rooms.pets_allowed', $pets_allowed);
        }

        if(isset($amenities)) {
            $new_amenities = array();
            foreach ($amenities as $amenity) {
                if($amenity != null || $amenity != 0){
                    array_push($new_amenities, (int)$amenity); 
                }
            }
            if(count($new_amenities) == 1) {
                $query->join('amenity_rooms', 'rooms.id', 'amenity_rooms.room_id')
                    ->join('amenities', 'amenity_rooms.amenity_id', 'amenities.id')
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

        $rooms = $query->paginate($limit);
        return $rooms;
    }

    public function getUserRooms($userId) {
        $limit = Room::get('limit') ?: 20;
        $page = Room::get('offset');
        request()->request->add(['page' => $page ?: 1]);
        

        $query = $this->roomQuery();
        $rooms = $query->where('users.id', $userId)
                ->orderBy('rooms.created_at', 'desc')
                ->paginate($limit);           

        return $rooms;
    }

    public function deleteRoom($roomId) {
        $room = $this->checkIfRoomExists($roomId);
        return $room->delete();
    }

    public function getFavouriteRooms() {
        $limit = Room::get('limit') ?: 20;
        $page = Room::get('offset');
        request()->request->add(['page' => $page ?: 1]);

        $query = $this->roomQuery();
        return $query->where('is_available', 1)
            ->join('favourite_rooms', 'rooms.id', 'favourite_rooms.room_id')
            ->where('favourite_rooms.user_id', \Auth::guard('api')->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    public function addNewRoom($request, $address) {
        $room = new Room;
        $room->title = $request->title;
        $room->user_id = auth()->user()->id;
        $room->address_id = $address->id;
        $room->currency = $request->currency;
        $room->rent = $request->rent;
        if($request->move_date) {
            $room->move_date = $request->move_date;
        }
        if($request->leave_date) {
            $room->leave_date = $request->leave_date;
        }
        if($request->description) {
            $room->description = $request->description;
        }
        // Residence
        if($request->building_type) {
            $room->building_type = $request->building_type;
        }
        if($request->move_in_fee) {
            $room->move_in_fee = $request->move_in_fee;
        }
        if($request->utilities_cost) {
            $room->utilities_cost = $request->utilities_cost;
        }
        if($request->parking_rent) {
            $room->parking_rent = $request->parking_rent;
        }
        if($request->furnished) {
            $room->furnished = $request->furnished;
        }

        if($request->pets_allowed) {
            $room->pets_allowed = $request->pets_allowed;
        }
        $room->save();
        if($request->amenities) {
            $room->amenities()->sync($request->amenities);
        }
        $room = $this->findRoomById($room->id);
        return $room;
    }

    public function updateRoom($request, $roomId) {
        $room = $this->checkIfRoomExists($roomId);
        $auth_user = auth()->user()->id;
        if($room->user_id !== $auth_user) {
            throw new ModelNotFoundException("room not found");
        }
        $room->title = $request->title;
        $room->user_id = $auth_user;
        $room->currency = $request->currency;
        $room->rent = $request->rent;
        $room->move_date = $request->move_date;
        if($request->leave_date) {
            $room->leave_date = $request->leave_date;
        }
        if($request->description) {
            $room->description = $request->description;
        }
        if($request->building_type) {
            $room->building_type = $request->building_type;
        }
        if($request->move_in_fee) {
            $room->move_in_fee = $request->move_in_fee;
        }
        if($request->utilities_cost) {
            $room->utilities_cost = $request->utilities_cost;
        }
        if($request->parking_rent) {
            $room->parking_rent = $request->parking_rent;
        }
        if($request->furnished) {
            $room->furnished = $request->furnished;
        }
        if($request->pets_allowed) {
            $room->pets_allowed = $request->pets_allowed;
        }
        if($request->is_available) {
            $room->is_available = $request->is_available;
        }

        $room->save();

        if($request->amenities) {
            (new AmenityRoom)->deleteRoomAmenities($room->id);
            $room->amenities()->sync($request->amenities);
        }

        (new RoomImage)->deleteImagesByRoomId($room->id);
        $room = $this->findRoomById($room->id);
        return $room;
    }

    public function markUnavailable($roomId) {
        $room = $this->checkIfRoomExists($roomId);
        $auth_user = auth()->user()->id;
        if($room->user_id !== $auth_user) {
            throw new ModelNotFoundException("room not found");
        }
        $room->is_available = false;
        $room->save();
        $room = $this->findRoomById($room->id);
        return $room;
    }

    public function markAvailable($roomId) {
        $room = $this->checkIfRoomExists($roomId);
        $auth_user = auth()->user()->id;
        if($room->user_id !== $auth_user) {
            throw new ModelNotFoundException("room not found");
        }
        $room->is_available = true;
        $room->save();
        $room = $this->findRoomById($room->id);
        return $room;
    }

    public function roomDataTableQuery() {
        $query = Room::join('addresses', 'rooms.address_id', 'addresses.id')
                    ->join('users','rooms.user_id', 'users.id')
                    ->select('rooms.*', 'addresses.location', 'users.name');
        return $query;
    }
}

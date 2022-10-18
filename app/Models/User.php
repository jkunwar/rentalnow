<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\ImageManagerStatic as Img;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'gender', 'dob', 'profile_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($identifier)
    {
        return $this->join('providers', 'users.id', 'providers.user_id')->where('providers.username', $identifier)->select('users.id', 'providers.username', 'providers.password')->first();
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }

    public function favouriteRooms()
    {
        return $this->belongsToMany('App\Models\FavouriteRoom', 'favourite_rooms', 'user_id', 'room_id')->withTimeStamps();
    }

    public function rooms()
    {
        return $this->hasMany('App\Models\Room');
    }

    public function houses()
    {
        return $this->hasMany('App\Models\House');
    }

    public function favouriteHouses()
    {
        return $this->belongsToMany('App\Models\FavouriteHouse', 'favourite_houses', 'user_id', 'house_id')->withTimeStamps();
    }

    public function favourites()
    {
        return $this->belongsToMany('App\Models\Favourite', 'favourites', 'user_id', 'property_id')->withTimeStamps();
    }

    public function findUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }
        return $user;
    }

    public function getUserById($id)
    {
        $user = User::where('users.id', $id)
            ->leftJoin('addresses', 'users.address_id', 'addresses.id')
            ->join('providers', 'users.id', 'providers.user_id')
            ->select('users.*', 'providers.phone_number', 'providers.email', 'addresses.location', 'addresses.location_id', 'addresses.latitude', 'addresses.longitude')
            ->first();
        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }
        return $user;
    }

    public function createUser($data)
    {
        $user = new User;
        $user->name = $data->name;
        if ($data->dob) {
            $user->dob = $data->dob;
        }

        if ($data->gender) {
            $user->gender = $data->gender;
        }

        if ($data->image) {
            $user->profile_image = $this->saveImageFromExternalLink($data->image);
        }
        $user->save();
        return $user;
    }

    public function saveImageFromExternalLink($imageUrl)
    {
        $contents = file_get_contents($imageUrl);
        $file_name = date('ymdhis');
        $file_name_to_store = $file_name . '.png';
        $name = 'public/images/user/' . $file_name_to_store;
        Storage::put($name, $contents);
        $user_image = 'storage/images/user/' . $file_name_to_store;
        return $user_image;
    }

    public function updateUser($data, $address = null)
    {
        $user_id = auth()->user()->id;
        $user = $this->findUserById($user_id);
        if ($data->name) {
            $user->name = $data->name;
        }
        if ($data->gender) {
            $user->gender = $data->gender;
        }
        if ($data->dob) {
            $user->dob = $data->dob;
        }
        if ($address) {
            $user->address_id = $address->id;
        }
        if ($data->email || $data->phone_number) {
            (new Provider)->updateEmailPhone($data);
        }
        $user->save();

        return $this->getUserById($user->id);
    }

    public function changeProfilePicture($request)
    {
        if ($request->hasFile('image')) {
            $user_id = auth()->user()->id;
            $this->deleteProfileImage($user_id);

            $file_name = date('ymdhis');
            $extname = $request->file('image')->getClientOriginalExtension();
            $file_name_to_store = $file_name . '.' . $extname;
            $path = $request->file('image')->storeAs('public/images/user', $file_name_to_store);

            $img = Img::make($request->file('image')->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::put('public/thumbnails/user/small_' . $file_name_to_store, (string) $img->encode());
            $user = $this->findUserById($user_id);
            $user->profile_image = 'storage/images/user/' . $file_name_to_store;
            $user->save();

            $user = $this->getUserById($user_id);
            return $user;
        }
    }

    public function deleteProfileImage($userId)
    {
        $image = User::where([['id', $userId], ['profile_image', '!=', null]])->first();
        if ($image) {
            $image_name = explode('/', $image->profile_image);
            @unlink('storage/images/user/' . $image_name[3]);
            @unlink('storage/thumbnails/user/small_' . $image_name[3]);
        }
    }

    public function userDataTableQuery()
    {
        $query = User::select('users.*')
            ->withCount('rooms as total_rooms')
            ->withCount('houses as total_houses');
        return $query;
    }
}

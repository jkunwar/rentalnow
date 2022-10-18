<?php

namespace App\Models;

use App\Jobs\GetLatLngJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Address extends Model
{
    protected $fillable = [
        'location_id', 'country_id', 'state', 'postal_code', 'latitude', 'longitude'
    ];

    public function getLatitudeAttribute($latitude)
    {
        return (float)$latitude;
    }

    public function getLongitudeAttribute($longitude)
    {
        return (float)$longitude;
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country')->select('country', 'country_code');
    }

    public function findByLocationId($locationId)
    {
        $address = Address::where('location_id', $locationId)->first();
        if (!$address) {
            throw new ModelNotFoundException('address not found');
        }
        return $address;
    }

    public function createNewAddress($request)
    {
        $address = new Address;
        if (isset($request['location_id'])) {
            $address->location_id = $request['location_id'];
        }
        $address->location = $request['location'];
        $address->latitude  = $request['latitude'];
        $address->longitude  = $request['longitude'];
        $address->save();
        return $address;
    }

    public function findNullLatitudeAndLongitudeAddress()
    {
        $addresses = Address::where([['latitude', null], ['longitude', null]])->get();
        return $addresses;
    }

    public function setLatLng($location)
    {
        $address = $this->findByLocationId($location['location_id']);
        $address->latitude = $location['latitude'];
        $address->longitude = $location['longitude'];
        $address->save();
    }
}

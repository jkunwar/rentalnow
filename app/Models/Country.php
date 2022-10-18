<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_code', 'phone_code',
    ];

    public function findOrCreateCountry($request)
    {
        $country = Country::where('country_code', 'ILIKE', $request['country_code'])->first();
        if (!$country) {
            $country = $this->createCountry($request);
        }
        return $country;
    }

    public function createCountry($request)
    {
        $country = new Country;
        $country->country_name = $request['country'];
        $country->country_code = $request['country_code'];
        if (isset($request['phone_code'])) {
            $country->phone_code = $request['phone_code'];
        }
        $country->save();
        return $country;
    }
}

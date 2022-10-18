<?php

use App\Models\Amenity;
use Faker\Generator as Faker;

$factory->define(App\Models\AmenityRoom::class, function (Faker $faker) {
    $amenities = Amenity::where('amenity_for', 'rooms')->orWhere('amenity_for', 'both')->pluck('id')->toArray();
    return [
        'amenity_id' => $amenity->id,
        'room_id' => $faker->numberBetween($min = 1, $max = 100),
    ];
});

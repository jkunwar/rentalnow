<?php

use App\Models\Amenity;
use Faker\Generator as Faker;

$factory->define(App\Models\AmenityHouse::class, function (Faker $faker) {
	$amenities = Amenity::where('amenity_for', 'houses')->orWhere('amenity_for', 'both')->get();
	foreach ($amenities as $amenity) {
		return [
			'amenity_id' => $amenity->id,
			'house_id' => $faker->numberBetween($min = 1, $max = 100),
		];
	}
});

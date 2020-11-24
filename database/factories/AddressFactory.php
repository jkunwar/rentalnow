<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Address::class, function (Faker $faker) {
    return [
        'location_id' => 'ChIJ1VfyrLIZ6zkRAMWh1BBSlL0',
        'country_id' => $faker->numberBetween($min = 1, $max = 120),
        'location' => $faker->streetAddress,
        'latitude' => $faker->latitude($min = -90, $max = 90),
        'longitude' => $faker->longitude($min = -180, $max = 180)
    ];
});

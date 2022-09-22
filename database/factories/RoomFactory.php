<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Room::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'user_id' => $faker->numberBetween($min =1, $max = 500),
        'address_id' => $faker->numberBetween($min = 1, $max = 200),
        'currency' => $faker->randomElement($array = array('AUD','USD','CAD')),
        'rent' => $faker->numberBetween($min = 300, $max = 1500),
        'move_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'leave_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'description' => $faker->text,

        //residence
        'building_type' => $faker->randomElement($array = array ('building apartment (1-10) units','building apartment (10+) units','building complex','house')),
        'move_in_fee' => $faker->numberBetween($min = 100, $max = 300),
        'utilities_cost' => $faker->numberBetween($min = 100, $max = 200),
        'parking_rent' => $faker->numberBetween($min = 50, $max = 200),
        'furnished' => $faker->randomElement($array = array(true, false)),
        'pets_allowed' => $faker->randomElement($array = array(true, false))
    ];
});

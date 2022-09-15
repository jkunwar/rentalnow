<?php

use Faker\Generator as Faker;

$factory->define(App\Models\House::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'user_id' => $faker->numberBetween($min = 1, $max = 500),
        'address_id' => $faker->numberBetween($min = 1, $max = 200),
        'currency' => $faker->randomElement($array = array('AUD', 'USD', 'CAD')),
        'rent' => $faker->numberBetween($min = 300, $max = 1500),
        'move_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'leave_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'description' => $faker->text,

        //residence
        'bedrooms' => $faker->randomElement($array = array('studio', '1', '2', '3', '4')),
        'bathrooms' => $faker->numberBetween($min = 1, $max = 3),
        'measurement' => $faker->numberBetween($min = 20, $max = 50),
        'm_unit' => $faker->randomElement($array = array('square meter', 'square feet')),
        'furnished' => $faker->randomElement($array = array(true, false)),
        'pets_allowed' => $faker->randomElement($array = array(true, false))
    ];
});

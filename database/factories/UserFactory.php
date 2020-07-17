<?php

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'gender'=> $faker->randomElement($array = array ('male','female','other')),
        'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'address_id' => $faker->numberBetween($min = 1, $max = 200),
    ];
});

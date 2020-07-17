<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Provider::class, function (Faker $faker) {

	$username = $faker->unique()->username;
    return [
        'user_id' => $faker->unique()->numberBetween($min =1, $max = 500),
        'username' => $username,
        'password' => bcrypt($username),
        'email' => $faker->safeEmail,
        'phone_number' => $faker->e164PhoneNumber,
        'provider' => $faker->randomElement($array = array ('google','facebook')),
        'token' => $faker->sha256
    ];
});

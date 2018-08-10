<?php

/* Participant  Factory */
$factory->define(App\Participant::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'position' => $faker->sentence(),
        'email' => $faker->email,
        'phone' => $faker->e164PhoneNumber,
    ];
});

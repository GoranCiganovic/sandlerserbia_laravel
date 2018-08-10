<?php

/* GlobalTraining Factory */
$factory->define(App\GlobalTraining::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'representative' => $faker->name,
        'phone' => $faker->e164PhoneNumber,
        'email' => $faker->email,
        'website' => $faker->domainName,
        'address' => $faker->address,
        'county' => $faker->state,
        'postal' => $faker->numberBetween(10000, 90000),
        'city' => $faker->city,
        'bank' => $faker->company,
        'account' => $faker->creditCardNumber,
        'identification' => $faker->numberBetween(10000000, 99999999),
        'pib' => $faker->numberBetween(100000000, 999999999),
    ];
});

<?php

/* Rate  Factory */
$factory->define(App\Rate::class, function (Faker\Generator $faker) {
    return [
        'sandler' => $faker->randomFloat(2, 0, 100),
        'sandler_paying_day' => $faker->numberBetween(1, 30),
        'pdv' => $faker->randomFloat(2, 0, 100),
        'pdv_paying_day' => $faker->numberBetween(1, 30),
        'ppo' => $faker->randomFloat(2, 0, 100),
        'disc' => $disc = $faker->randomFloat(2, 0, 1000),
        'devine' => $devine = $faker->randomFloat(2, 0, 1000),
        'disc_devine' => $disc + $devine,
        'dd_paying_day' => $faker->numberBetween(1, 30),
    ];
});


/* Rate  Factory  Current Rate */
$factory->defineAs(App\Rate::class, 'current_rate', function ($faker) use ($factory) {
    return [
        'id' => 1,
        'sandler' => 11.25,
        'sandler_paying_day' => 15,
        'pdv' => 20.00,
        'pdv_paying_day' => 15,
        'disc' => 25.00,
        'devine' => 80.00,
        'disc_devine' => 105.00,
        'dd_paying_day' => 20,
        'ppo' => 20.00
    ];
});

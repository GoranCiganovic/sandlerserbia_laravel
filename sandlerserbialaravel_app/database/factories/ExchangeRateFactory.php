<?php

/* ExchangeRate Factory */
$factory->define(App\ExchangeRate::class, function (Faker\Generator $faker) {
    return [
        'currency' => $faker->unique()->word,
        'value' => $faker->randomFloat(4, 80, 200),
    ];
});

/* Exhange Euro */
$factory->defineAs(App\ExchangeRate::class, 'euro', function ($faker) use ($factory) {
    $exchange = $factory->raw(App\ExchangeRate::class);
    return array_merge($exchange, [
        'id' => 1,
        'currency' => 'EUR',
        'value' => 118.2563,
    ]);
});

/* Exhange Dollar */
$factory->defineAs(App\ExchangeRate::class, 'dollar', function ($faker) use ($factory) {
    $exchange = $factory->raw(App\ExchangeRate::class);
    return array_merge($exchange, [
        'id' => 2,
        'currency' => 'USD',
        'value' => 95.3626,
    ]);
});

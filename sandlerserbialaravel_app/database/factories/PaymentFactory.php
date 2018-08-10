<?php

/* Payment  Factory */
$factory->define(App\Payment::class, function (Faker\Generator $faker) {
    return [
        'pay_date_desc' => $faker->sentence(),
        'description' => $faker->sentence(),
    ];
});

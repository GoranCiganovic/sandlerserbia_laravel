<?php

/* Client Factory - Legal or Individual  */
$factory->define(App\Client::class, function (Faker\Generator $faker) {
    return [
        'legal_status_id' => rand(1, 2),
    ];
});

<?php

/* Template Factory */
$factory->define(App\Template::class, function (Faker\Generator $faker) {
    return [
        'logo_bg' => $faker->numberBetween(0, 1),
        'logo_hd' => $faker->numberBetween(0, 1),
        'line_hd' => $faker->numberBetween(0, 1),
        'line_ft' => $faker->numberBetween(0, 1),
        'paginate' => $faker->numberBetween(0, 1),
        'margin_top' => $faker->numberBetween(0, 50),
        'margin_right' => $faker->numberBetween(0, 50),
        'margin_bottom' => $faker->numberBetween(0, 50),
        'margin_left' => $faker->numberBetween(0, 50),
    ];
});

/* Template Factory - Default */
$factory->defineAs(App\Template::class, 'default', function ($faker) use ($factory) {
    $template = $factory->raw(App\Template::class);
    return array_merge($template, [
        'id' => 1,
        'logo_bg' => 1,
        'logo_hd' => 1,
        'line_hd' => 1,
        'line_ft' => 1,
        'paginate' => 1,
        'margin_top' => 30,
        'margin_right' => 15,
        'margin_bottom' => 15,
        'margin_left' => 15
    ]);
});

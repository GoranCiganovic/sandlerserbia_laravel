<?php

/* Company Size Factory */
$factory->define(App\CompanySize::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(45)
    ];
});

/* Company Size Factory - Unknown */
$factory->defineAs(App\CompanySize::class, 'unknown', function ($faker) use ($factory) {
    $company_size = $factory->raw(App\CompanySize::class);
    return array_merge($company_size, [
        'id' => 1,
        'name' => 'Nepoznato',
    ]);
});

/* Company Size Factory - Micro */
$factory->defineAs(App\CompanySize::class, 'micro', function ($faker) use ($factory) {
    $company_size = $factory->raw(App\CompanySize::class);
    return array_merge($company_size, [
        'id' => 2,
        'name' => 'Mikro',
    ]);
});

/* Company Size Factory - Small */
$factory->defineAs(App\CompanySize::class, 'small', function ($faker) use ($factory) {
    $company_size = $factory->raw(App\CompanySize::class);
    return array_merge($company_size, [
        'id' => 3,
        'name' => 'Malo',
    ]);
});

/* Company Size Factory - Medium */
$factory->defineAs(App\CompanySize::class, 'medium', function ($faker) use ($factory) {
    $company_size = $factory->raw(App\CompanySize::class);
    return array_merge($company_size, [
        'id' => 4,
        'name' => 'Srednje',
    ]);
});

/* Company Size Factory - Large */
$factory->defineAs(App\CompanySize::class, 'large', function ($faker) use ($factory) {
    $company_size = $factory->raw(App\CompanySize::class);
    return array_merge($company_size, [
        'id' => 5,
        'name' => 'Veliko',
    ]);
});

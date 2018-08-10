<?php

/* User Factory And Administrator User Factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->e164PhoneNumber,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret or bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'is_admin' => 0,
        'is_unauthorized' => 0,
    ];
});

/* Admin Users */
$factory->defineAs(App\User::class, 'is_admin', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['is_admin' => 1]);
});

/* Authorized Non Admin Users */
$factory->defineAs(App\User::class, 'authorized', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['is_admin' => 0, 'is_unauthorized' => 0]);
});

/* Unauthorized Non Admin Users */
$factory->defineAs(App\User::class, 'unauthorized', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['is_admin' => 0, 'is_unauthorized' => 1]);
});

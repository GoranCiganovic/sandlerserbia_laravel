<?php

/* Individual Client Factory */
$factory->define(App\Individual::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->unique()->e164PhoneNumber,
        'email' => $faker->safeEmail,
        'jmbg' => $faker->unique()->numberBetween(1000000000000, 9999999999999),
        'id_card' => $faker->unique()->creditCardNumber,
        'works_at' => $faker->company,
        'address' => $faker->address,
        'county' => $faker->state,
        'postal' => $faker->postcode,
        'city' => $faker->city,
        'comment' => $faker->realText,
        'client_id' => function () {
            return factory(App\Client::class)->create(['legal_status_id' => 2])->id;
        },
    ];
});

/* Uncontacted Client */
$factory->defineAs(App\Individual::class, 'uncontacted', function ($faker) use ($factory) {
    $individual = $factory->raw(App\Individual::class);

    return array_merge($individual, ['client_status_id' => 1]);
});

/* Disqualified Without Meeting Client */
$factory->defineAs(App\Individual::class, 'disqualified_without_meeting', function ($faker) use ($factory) {
    $individual = $factory->raw(App\Individual::class);

    return array_merge($individual, [
        'client_status_id' => 2,
        'conversation_date' => $faker->dateTimeBetween('-1 years'),
    ]);
});

/* Disqualified After Meeting Client */
$factory->defineAs(App\Individual::class, 'disqualified_after_meeting', function ($faker) use ($factory) {
    $individual = $factory->raw(App\Individual::class);

    return array_merge($individual, [
        'client_status_id' => 2,
        'conversation_date' => $conversation_date = $faker->dateTimeBetween('-1 years'),
        'accept_meeting_date' => $conversation_date,
        'meeting_date' => $faker->dateTimeInInterval($conversation_date, '+7days'),
    ]);
});

/* Accept Meeting Client */
$factory->defineAs(App\Individual::class, 'accept_meeting', function ($faker) use ($factory) {
    $individual = $factory->raw(App\Individual::class);

    return array_merge($individual, [
        'client_status_id' => 3,
        'conversation_date' => $conversation_date = $faker->dateTimeBetween('-1 years'),
        'accept_meeting_date' => $conversation_date,
        'meeting_date' => $faker->dateTimeInInterval($conversation_date, '+7 days'),
    ]);
});

/* JPB Client */
$factory->defineAs(App\Individual::class, 'jpb', function ($faker) use ($factory) {
    $individual = $factory->raw(App\Individual::class);

    return array_merge($individual, [
        'client_status_id' => 4,
        'conversation_date' => $faker->dateTimeBetween('-1 years'),
    ]);
});

/* Inactive Client */
$factory->defineAs(App\Individual::class, 'inactive', function ($faker) use ($factory) {
    $individual = $factory->raw(App\Individual::class);

    return array_merge($individual, [
        'client_status_id' => 5,
        'conversation_date' => $conversation_date = $faker->dateTimeBetween('-1 years'),
        'accept_meeting_date' => $conversation_date,
        'meeting_date' => $meeting_date = $faker->dateTimeInInterval($conversation_date, '+7 days'),
        'closing_date' => $faker->dateTimeInInterval($meeting_date, '+7 days'),
    ]);
});

/* Active Client */
$factory->defineAs(App\Individual::class, 'active', function ($faker) use ($factory) {
    $individual = $factory->raw(App\Individual::class);

    return array_merge($individual, [
        'client_status_id' => 6,
        'conversation_date' => $conversation_date = $faker->dateTimeBetween('-1 years'),
        'accept_meeting_date' => $conversation_date,
        'meeting_date' => $meeting_date = $faker->dateTimeInInterval($conversation_date, '+7 days'),
        'closing_date' => $faker->dateTimeInInterval($meeting_date, '+7 days'),
    ]);
});

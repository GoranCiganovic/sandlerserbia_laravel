<?php

/* Legal Client Factory */
$factory->define(App\Legal::class, function (Faker\Generator $faker) {
    return [
        'long_name' => $faker->unique()->company,
        'short_name' => $faker->unique()->company,
        'ceo' => $faker->name,
        'phone' => $faker->unique()->e164PhoneNumber,
        'email' => $faker->safeEmail,
        'contact_person' => $faker->name,
        'contact_person_phone' => $faker->unique()->e164PhoneNumber,
        'identification' => $faker->unique()->numberBetween(10000000, 99999999),
        'pib' => $faker->unique()->numberBetween(100000000, 999999999),
        'activity' => $faker->catchPhrase,
        'address' => $faker->address,
        'county' => $faker->state,
        'postal' => $faker->postcode,
        'city' => $faker->city,
        'website' => $faker->domainName,
        'comment' => $faker->realText,
        'company_size_id' => $faker->numberBetween(1, 5),
        'client_id' => function () {
            return factory(App\Client::class)->create(['legal_status_id' => 1])->id;
        },
    ];
});

/* Uncontacted Client*/
$factory->defineAs(App\Legal::class, 'uncontacted', function ($faker) use ($factory) {
    $legal = $factory->raw(App\Legal::class);

    return array_merge($legal, ['client_status_id' => 1]);
});

/* Disqualified Without Meeting Client */
$factory->defineAs(App\Legal::class, 'disqualified_without_meeting', function ($faker) use ($factory) {
    $legal = $factory->raw(App\Legal::class);

    return array_merge($legal, [
        'client_status_id' => 2,
        'conversation_date' => $faker->dateTimeBetween('-1 years'),
    ]);
});

/* Disqualified After Meeting Client */
$factory->defineAs(App\Legal::class, 'disqualified_after_meeting', function ($faker) use ($factory) {
    $legal = $factory->raw(App\Legal::class);

    return array_merge($legal, [
        'client_status_id' => 2,
        'conversation_date' => $conversation_date = $faker->dateTimeBetween('-1 years'),
        'accept_meeting_date' => $conversation_date,
        'meeting_date' => $faker->dateTimeInInterval($conversation_date, '+7 days'),
    ]);
});

/* Accept Meeting Client */
$factory->defineAs(App\Legal::class, 'accept_meeting', function ($faker) use ($factory) {
    $legal = $factory->raw(App\Legal::class);

    return array_merge($legal, [
        'client_status_id' => 3,
        'conversation_date' => $conversation_date = $faker->dateTimeBetween('-1 years'),
        'accept_meeting_date' => $conversation_date,
        'meeting_date' => $faker->dateTimeInInterval($conversation_date, '+7 days'),
    ]);
});

/* JPB Client */
$factory->defineAs(App\Legal::class, 'jpb', function ($faker) use ($factory) {
    $legal = $factory->raw(App\Legal::class);

    return array_merge($legal, [
        'client_status_id' => 4,
        'conversation_date' => $faker->dateTimeBetween('-1 years'),
    ]);
});

/* Inactive Client */
$factory->defineAs(App\Legal::class, 'inactive', function ($faker) use ($factory) {
    $legal = $factory->raw(App\Legal::class);

    return array_merge($legal, [
        'client_status_id' => 5,
        'conversation_date' => $conversation_date = $faker->dateTimeBetween('-1 years'),
        'accept_meeting_date' => $conversation_date,
        'meeting_date' => $meeting_date = $faker->dateTimeInInterval($conversation_date, '+7 days'),
        'closing_date' => $faker->dateTimeInInterval($meeting_date, '+7 days'),
    ]);
});

/* Active Client */
$factory->defineAs(App\Legal::class, 'active', function ($faker) use ($factory) {
    $legal = $factory->raw(App\Legal::class);

    return array_merge($legal, [
        'client_status_id' => 6,
        'conversation_date' => $conversation_date = $faker->dateTimeBetween('-1 years'),
        'accept_meeting_date' => $conversation_date,
        'meeting_date' => $meeting_date = $faker->dateTimeInInterval($conversation_date, '+7 days'),
        'closing_date' => $faker->dateTimeInInterval($meeting_date, '+7 days'),
    ]);
});

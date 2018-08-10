<?php

/* Contracts Factory (Max 1000 Contracts) */
if (!function_exists('autoIncrement')) {
    function autoIncrement()
    {
        for ($i = 0; $i < 1000; $i++) {
            yield $i;
        }
    }
}
$autoIncrement = autoIncrement();

$factory->define(App\Contract::class, function (Faker\Generator $faker) use ($autoIncrement) {
    $autoIncrement->next();
    return [
        'contract_number' => $autoIncrement->current(),
        'value' => $value = $faker->numberBetween(5000, 100000),
        'value_letters' => $faker->text,
        'advance' => $faker->numberBetween(0, 2000),
        'payments' => rand(0, 24),
        'participants' => $faker->numberBetween(1, 12),
        'paid' => 0,
        'rest' => $value,
        'event_place' => $faker->sentence,
        'classes_number' => $faker->sentence,
        'work_dynamics' => $faker->sentence,
        'event_time' => $faker->sentence,
        'description' => $faker->realText,
        'contract_date' => $contract_date = $faker->dateTimeBetween('-1 years'),
        'start_date' => $faker->dateTimeBetween($contract_date),
        'end_date' => $faker->dateTimeBetween($contract_date, '+1 months'),
        'html' => $faker->realText,
    ];
});

 
/* Factory For Seeding */

/* Unsigned Contract Legal Client */
$factory->defineAs(App\Contract::class, 'unsigned_legal', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);

    return array_merge($contract, [
        'contract_status_id' => 1,
        'legal_status_id' => 1,
        'client_id' => factory(App\Legal::class, 'accept_meeting')->create()->client_id
    ]);
});

/* In progress Contract Legal Client */
$factory->defineAs(App\Contract::class, 'in_progress_legal', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);

    return array_merge($contract, [
        'contract_status_id' => 2,
        'value' => $value = $faker->numberBetween(5000, 100000),
        'paid' => $value / 2,
        'rest' => $value / 2,
        'legal_status_id' => 1,
        'client_id' => factory(App\Legal::class, 'active')->create()->client_id
    ]);
});

/* Finished Contract Legal Client */
$factory->defineAs(App\Contract::class, 'finished_legal', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);

    return array_merge($contract, [
        'contract_status_id' => 3,
        'value' => $value = $faker->numberBetween(5000, 100000),
        'paid' => $value,
        'rest' => 0,
        'legal_status_id' => 1,
        'client_id' => factory(App\Legal::class, 'active')->create()->client_id
    ]);
});

/* Broken Contract Legal Client */
$factory->defineAs(App\Contract::class, 'broken_legal', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);

    return array_merge($contract, [
        'contract_status_id' => 4,
        'legal_status_id' => 1,
        'client_id' => factory(App\Legal::class, 'inactive')->create()->client_id
    ]);
});


/* Unsigned Contract Individual Client */
$factory->defineAs(App\Contract::class, 'unsigned_individual', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);

    return array_merge($contract, [
        'contract_status_id' => 1,
        'legal_status_id' => 2,
        'client_id' => factory(App\Individual::class, 'accept_meeting')->create()->client_id
    ]);
});

/* In progress Contract Individual Client */
$factory->defineAs(App\Contract::class, 'in_progress_individual', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);

    return array_merge($contract, [
        'contract_status_id' => 2,
        'value' => $value = $faker->numberBetween(5000, 100000),
        'paid' => $value / 2,
        'rest' => $value / 2,
        'legal_status_id' => 2,
        'client_id' => factory(App\Individual::class, 'active')->create()->client_id
    ]);
});

/* Finished Contract Individual Client */
$factory->defineAs(App\Contract::class, 'finished_individual', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);

    return array_merge($contract, [
        'contract_status_id' => 3,
        'value' => $value = $faker->numberBetween(5000, 100000),
        'paid' => $value,
        'rest' => 0,
        'legal_status_id' => 2,
        'client_id' => factory(App\Individual::class, 'active')->create()->client_id
    ]);
});

/* Broken Contract Individual Client */
$factory->defineAs(App\Contract::class, 'broken_individual', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);

    return array_merge($contract, [
        'contract_status_id' => 4,
        'legal_status_id' => 2,
        'client_id' => factory(App\Individual::class, 'inactive')->create()->client_id
    ]);
});



/* Factory For Testing */

/* Unsigned Legal Client Contract  For Testing */
$factory->defineAs(App\Contract::class, 'testing_unsigned_legal', function ($faker) use ($factory) {
    $contract = $factory->raw(App\Contract::class);
    return array_merge($contract, [
        'contract_status_id' => 1,
        'legal_status_id' => 1,
    ]);
});

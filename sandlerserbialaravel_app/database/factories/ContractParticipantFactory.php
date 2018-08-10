<?php

/*  Factory */
$factory->define(App\ContractParticipant::class, function (Faker\Generator $faker) {
    return [
        'contract_id' => rand(1, 10),
        'participant_id' => rand(1, 10)
    ];
});

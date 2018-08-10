<?php

/* DiscDevine Factory */
$factory->define(App\DiscDevine::class, function (Faker\Generator $faker) {
    return [
        'disc_dollar' => $disc_dollar = 25,
        'devine_dollar' => $devine_dollar = 80,
        'dd_dollar' => $dd_dollar = $disc_dollar + $devine_dollar,
        'middle_ex_dollar' => $middle_ex_dollar = 95.1456,
        'dd_din' => $dd_din = round($dd_dollar * $middle_ex_dollar, 2),
        'ppo' => $ppo = 20,
        'ppo_din' => round(($dd_din * $ppo) / 100, 2),
    ];
});

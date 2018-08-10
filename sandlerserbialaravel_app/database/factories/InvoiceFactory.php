<?php

/* Invoice  Factory (Max 100 Invoices) */
if (!function_exists('autoIncrement')) {
    function autoIncrement()
    {
        for ($i = 0; $i < 100; $i++) {
            yield $i;
        }
    }
}
$autoIncrement = autoIncrement();
/* Invoice Factory */
$factory->define(App\Invoice::class, function (Faker\Generator $faker) use ($autoIncrement) {
    $autoIncrement->next();
    return [
        'serial_number' => $serial_number = $autoIncrement->current(),
        'invoice_number' => $serial_number.'/'.date('Y'),
        'value_euro' => $value_euro = $faker->numberBetween(500, 1000),
        'exchange_euro' => $exchange = $faker->randomFloat(4, 90, 130),
        'value_din' => $value_din = round($value_euro*$exchange, 2),
        'pdv' => $pdv = $faker->randomFloat(2, 18, 22),
        'pdv_din' => $pdv_din = ($value_din*$pdv)/100,
        'value_din_tax' => $value_din+$pdv_din,
        'issue_date' => $issue_date = date('Y-m-d', strtotime("+".$autoIncrement->current()." month")),
        'traffic_date' => date('Y-m-d', strtotime("+".$autoIncrement->current()." month")),
        'description' => $faker->realText,
        'note' => $faker->text,
    ];
});


/* Invoice issued_presentation_invoice */
$factory->defineAs(App\Invoice::class, 'issued_presentation_invoice', function (Faker\Generator $faker) {

    $issue_date = $faker->dateTimeBetween('-2 months', '-1 months');
    $conversation_date = $faker->dateTimeBetween($issue_date, '-1 month');
    $accept_meeting_date = $faker->dateTimeBetween($conversation_date, '+3 days');
    $meeting_date = $faker->dateTimeBetween($accept_meeting_date, '+2 days');

    $client = factory(App\Client::class)->create();
    /* Create Legal Or Individual  */
    if ($client->legal_status_id == 1) {
        $client = factory(App\Legal::class)->create([
            'client_id' => $client->id,
            'client_status_id' => 6,
            'conversation_date' => $conversation_date,
            'accept_meeting_date' => $accept_meeting_date,
            'meeting_date' => $meeting_date,
            'closing_date' => $meeting_date,
        ]);
    } elseif ($client->legal_status_id == 2) {
        $client = factory(App\Individual::class)->create([
            'client_id' => $client->id,
            'client_status_id' => 6,
            'conversation_date' => $conversation_date,
            'accept_meeting_date' => $accept_meeting_date,
            'meeting_date' => $meeting_date,
            'closing_date' => $meeting_date,
        ]);
    }

    $serial_number = (\DB::table('invoices')->max('serial_number'));
    $serial_number++;

    return [
        'client_id' => $client->id,
        'serial_number' => $serial_number,
        'invoice_number' => $serial_number . '/' . date('Y'),
        'value_euro' => $value_euro = 5000,
        'exchange_euro' => $exchange_euro = 117.2536,
        'value_din' => $value_din = round($value_euro * $exchange_euro, 2),
        'pdv' => $pdv = 20,
        'pdv_din' => $pdv_din = round(($value_din * $pdv) / 100, 2),
        'value_din_tax' => $value_din_tax = round($value_din + $pdv_din, 2),
        'issue_date' => $issue_date,
        'paid_date' => $paid_date = $faker->dateTimeBetween($issue_date, '+3 days'),
        'traffic_date' => $faker->dateTimeBetween($issue_date, '-1 days'),
        'description' => $faker->sentence,
        'note' => $faker->sentence,
        'contract_id' => 0,
        'is_issued' => 1,
        'is_paid' => 0,

    ];
});

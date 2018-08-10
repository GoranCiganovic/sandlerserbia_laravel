<?php

use Illuminate\Database\Seeder;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Legal Contract Unsigned */
        factory(App\Contract::class, 5)
            ->create([
                'contract_status_id' => 1,
                'legal_status_id' => $legal_status_id = rand(1, 2),
                'client_id' => $this->create_client($legal_status_id),
            ])
            ->each(function ($u) {
                $contract_value = $u->value;
                $contract_date = $u->contract_date->format('Y-m-d');
                /* Insert Advance */
                if ($u->advance != '0') {
                    $contract_value = $u->value - $u->advance;
                    $u->payment()->save(factory(App\Payment::class)->make([
                        'value_euro' => $u->advance,
                        'pay_date' => $contract_date,
                        'pay_date_desc' => 'Odmah po potpisivanju Ugovora',
                        'description' => 'Avans',
                        'is_advance' => 1,
                    ]));
                }

                $start_paying_date = date('Y-m-d', strtotime('+1 months', strtotime($contract_date)));
                /* IINSERT PAYMENTS */
                for ($i = 0; $i < $u->payments; $i++) {
                    $u->payment()->save(factory(App\Payment::class)->make([
                        'value_euro' => $contract_value / $u->payments,
                        'pay_date' => date('Y-m-d', strtotime('+' . $i . ' months', strtotime($start_paying_date))),
                    ]));
                }
                $disc_devine_date = date('Y-m-d', strtotime('+3 days', strtotime($contract_date)));
                /* INSERT PARTICIPANTS */
                for ($i = 0; $i < $u->participants; $i++) {
                    $participant = $u->participant()->save(factory(App\Participant::class)->create([
                        'dd_date' => $disc_devine_date,
                    ]));
                    /* Paid Disc Devine In Previous Months */
                    if (date('m', strtotime('+3 days', strtotime($participant->dd_date))) != date('m')) {
                        $participant->disc_devine()->save(factory(App\DiscDevine::class)->make([
                            'make_date' => date('Y-m-d', strtotime('+3 days', strtotime($participant->dd_date))),
                            'paid_date' => date('Y-m-d', strtotime('+1 month', strtotime($participant->dd_date))),
                            'is_paid' => 1,
                            'participant_id' => $participant->id,
                        ]));
                    }
                }
            });
    }

    /**
     * Create CLient - Legal or Individual based on legal_status_id
     * @param  int $legal_status_id
     * @return mixed    Client Id
     */
    public function create_client($legal_status_id)
    {
        if ($legal_status_id == 1) {
            /* Create Legal Client */
            return factory(App\Legal::class)->create()->client_id;
        } elseif ($legal_status_id == 2) {
            /* Create Individual Client */
            return factory(App\Individual::class)->create()->client_id;
        }
    }
}

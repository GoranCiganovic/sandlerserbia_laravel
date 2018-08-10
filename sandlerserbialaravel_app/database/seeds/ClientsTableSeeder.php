<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Create Client Seeds - Legal And Individual
     *
     * @return void
     */
    public function run()
    {

        factory(App\Client::class, 20)->create()->each(function ($u) {

            /* Create Legal Or Individual  */
            if ($u->legal_status_id == 1) {
                $client = factory(App\Legal::class)->create([
                    'client_id' => $u->id,
                ]);
            } elseif ($u->legal_status_id == 2) {
                $client = factory(App\Individual::class)->create([
                    'client_id' => $u->id,
                ]);
            }
        });
    }
}

<?php

use Illuminate\Database\Seeder;

class IndividualsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Individual::class, 'uncontacted', 10)->create();
        factory(App\Individual::class, 'disqualified_without_meeting', 10)->create();
        factory(App\Individual::class, 'disqualified_after_meeting', 10)->create();
        factory(App\Individual::class, 'accept_meeting', 10)->create();
        factory(App\Individual::class, 'jpb', 10)->create();
        factory(App\Individual::class, 'inactive', 10)->create();
        factory(App\Individual::class, 'active', 10)->create();
    }
}

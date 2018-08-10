<?php

use Illuminate\Database\Seeder;

class LegalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Legal::class, 'uncontacted', 10)->create();
        factory(App\Legal::class, 'disqualified_without_meeting', 10)->create();
        factory(App\Legal::class, 'disqualified_after_meeting', 10)->create();
        factory(App\Legal::class, 'accept_meeting', 10)->create();
        factory(App\Legal::class, 'jpb', 10)->create();
        factory(App\Legal::class, 'inactive', 10)->create();
        factory(App\Legal::class, 'active', 10)->create();
    }
}

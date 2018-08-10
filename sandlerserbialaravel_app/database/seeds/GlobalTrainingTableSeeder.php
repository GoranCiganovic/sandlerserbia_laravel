<?php

use Illuminate\Database\Seeder;

class GlobalTrainingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\GlobalTraining::class, 1)->create();
    }
}

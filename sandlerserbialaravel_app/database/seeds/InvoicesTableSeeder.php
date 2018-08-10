<?php

use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Invoice::class, 'issued_presentation_invoice', 1)->create();
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* single user
                        DB::table('users')->insert([
                            'name' => str_random(10),
                            'email' => str_random(10) . '@gmail.com',
                            'password' => bcrypt('secret'),
                        ]);
        */

        factory(App\User::class, 'is_admin')->create([
            'name' => 'Goran Ciganović',
            'email' => 'ciga@beogrid.net',
            'password' => '$2y$10$7ghngr6VVZP.DBYX/39hnuppUBZptAPgfrAg6YyG66pO.VNvrU70W',
        ]);

        factory(App\User::class, 20)->create();
    }
}

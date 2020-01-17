<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([

            [
                'first_name' => 'Damir',
                'last_name' => 'Ibra',
                'username' => 'damiribra',
                'email' => 'damir@gmail.com',
                'password' => bcrypt('Damir'),
            ]
        ]);
    }
}

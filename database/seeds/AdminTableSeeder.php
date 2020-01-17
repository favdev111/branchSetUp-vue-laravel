<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        DB::table('admins')->insert([

            [
                'name' => 'Vicky',
                'email' => 'vicky@psof.com',
                'password' => bcrypt('#Vicky2019#'),
            ]
        ]);
    }
}

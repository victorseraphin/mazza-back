<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        \DB::table('users')->insert([
            'name' => 'Super User',
            'email' => 'super@email.com',
            'password' => bcrypt('123456'),
        ]);
    }
}

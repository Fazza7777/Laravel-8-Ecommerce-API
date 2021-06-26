<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Pyae Phyoe Naing',
            'email'=>'pyaephyoenaing@gmail.com',
            'phone'=>'09777758089',
            'password'=>bcrypt('password')
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Kinoshita',
                'email' => 'Kinoshita@example.com',
                'password' => Hash::make('password'),
                'address' => '東京都XXXXXXX',
                'is_admin' => true,
            ],
            [
                'name' => 'mutsura',
                'email' => 'mutsura@example.com',
                'password' => Hash::make('password'),
                'address' => '北海道XXXXXXX',
                'is_admin' => false,
            ],
        ]);
    }
}

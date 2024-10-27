<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'mostafa',
                'email' => 'mostafa@gmail.com',
                'password' => Hash::make(0000)
            ],

            [
                'name' => 'abd',
                'email' => 'abd@gmail.com',
                'password' => Hash::make(0000)
            ],

        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiscountCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discount_codes')->insert([
            [
                'discount_id' => 1,
                'code' => 'FIRST10',
                'used_count' => 0,
                'expiration_date' => now()->addDays(30),
                'is_active' => true
            ],
        ]);
    }
}

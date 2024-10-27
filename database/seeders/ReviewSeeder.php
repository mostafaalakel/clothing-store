<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'product_id' => 1,
                'user_id' => 1,
                'rating' => 5,
                'comments' => 'Excellent product!'
            ],
            [
                'product_id' => 2,
                'user_id' => 1,
                'rating' => 4,
                'comments' => 'Very good shoes.'
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_details')->insert([
            [
                'product_id' => 1,
                'size_id' => 1,
                'color_id' => 1,
                'quantity' => 10
            ],
            [
                'product_id' => 1,
                'size_id' => 2,
                'color_id' => 2,
                'quantity' => 5
            ],
            [
                'product_id' => 2,
                'size_id' => 3,
                'color_id' => 3,
                'quantity' => 8
            ],
        ]);
    }
}

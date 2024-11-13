<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cart_items')->insert([
            [
                'cart_id' => 1,
                'product_detail_id' => 2 ,
                'quantity' => 5

            ],
            [
                'cart_id' => 1,
                'product_detail_id' => 1 ,
                'quantity' => 5
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'product_detail_id' => 1,
                'quantity' => 1
            ],
            [
                'order_id' => 1,
                'product_detail_id' => 2,
                'quantity' => 1
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = DB::table('products')->pluck('id')->toArray();
        $discountIds = DB::table('discounts')->pluck('id')->toArray();

        foreach ($productIds as $productId) {
            $randomDiscounts = array_rand($discountIds, rand(1, count($discountIds)));
            
            foreach ((array) $randomDiscounts as $discountIndex) {
                DB::table('product_discounts')->insert([
                    'product_id' => $productId,
                    'discount_id' => $discountIds[$discountIndex],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

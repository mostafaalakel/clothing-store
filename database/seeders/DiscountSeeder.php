<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discounts')->insert([
            [
                'name' => json_encode(['en' => '10% Off', 'ar' => 'خصم 10%']),
                'description' => json_encode(['en' => 'Get 10% off on your first purchase.', 'ar' => 'احصل على خصم 10% على أول عملية شراء.']),
                'value' => 10.00,
                'discount_application' => 'code_based',
                'start_date' => now(),
                'end_date' => now()->addDays(30)
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            ProductDetailSeeder::class,
            CartSeeder::class,
            CartItemSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            ReviewSeeder::class,
            DiscountSeeder::class,
            DiscountCodeSeeder::class,
            ProductDiscountSeeder::class
        ]);
    }
}

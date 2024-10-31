<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'gender' => 'm',
                'name' => json_encode(['en' => 'Men\'s Shirt', 'ar' => 'قميص رجالي']),
                'description' => json_encode(['en' => 'A nice shirt.', 'ar' => 'قميص جميل.']),
                'price' => 29.99
            ],
            [
                'category_id' => 2,
                'gender' => 'f',
                'name' => json_encode(['en' => 'Women\'s Shoes', 'ar' => 'أحذية نسائية']),
                'description' => json_encode(['en' => 'Comfortable shoes.', 'ar' => 'أحذية مريحة.']),
                'price' => 49.99
            ],
        ]);
    }
}

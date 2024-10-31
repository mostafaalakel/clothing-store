<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => json_encode(['en' => 'Clothing', 'ar' => 'ملابس'] , JSON_UNESCAPED_UNICODE),
                'image' => 'path/to/image1.jpg'
            ],
            [
                'name' => json_encode(['en' => 'Footwear', 'ar' => 'أحذية'] , JSON_UNESCAPED_UNICODE),
                'image' => 'path/to/image2.jpg'
            ],
            [
                'name' => json_encode(['en' => 'Accessories', 'ar' => 'إكسسوارات'],JSON_UNESCAPED_UNICODE),
                'image' => 'path/to/image3.jpg'
            ],
        ]);
    }
}

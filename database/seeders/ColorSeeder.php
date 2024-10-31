<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => json_encode(['en' => 'Red', 'ar' => 'أحمر'],JSON_UNESCAPED_UNICODE)],
            ['name' => json_encode(['en' => 'Blue', 'ar' => 'أزرق'],JSON_UNESCAPED_UNICODE)],
            ['name' => json_encode(['en' => 'Green', 'ar' => 'أخضر'],JSON_UNESCAPED_UNICODE)],
        ]);
    }
}

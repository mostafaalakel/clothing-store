<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sizes')->insert([
            ['name' => json_encode(['en' => 'Small', 'ar' => 'صغير'])],
            ['name' => json_encode(['en' => 'Medium', 'ar' => 'متوسط'])],
            ['name' => json_encode(['en' => 'Large', 'ar' => 'كبير'])],
        ]);
    }
}

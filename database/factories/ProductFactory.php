<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word, // اسم عشوائي للمنتج
            'category_id' => 1,
            'description' => $this->faker->sentence, // وصف عشوائي
            'price' => $this->faker->numberBetween(10, 1000), // سعر عشوائي
            'gender' => $this->faker->randomElement(['m', 'f'  , 'a']), // جنس المنتج
        ];
    }
}

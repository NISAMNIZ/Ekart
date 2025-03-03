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
            'name' => fake()->name(),
            'description' => fake()->text(20),
            'price' => fake()->randomNumber(5),
            'category_id' => fake()->numberBetween(1,4),
            'status' => fake()->numberBetween(0,1),
            'is_favorite' => fake()->numberBetween(0,1)

        ];
    }
}

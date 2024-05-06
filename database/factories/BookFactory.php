<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sale_id' => fake()->numberBetween(1, 9),
            'title' => fake()->title(),
            'description' => fake()->jobTitle(),
            'rate' => fake()->numberBetween(4, 5),
            'price' => fake()->numberBetween(50000, 200000)
        ];
    }
}

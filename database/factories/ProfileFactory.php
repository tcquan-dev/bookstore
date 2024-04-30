<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 9),
            'avatar' => fake()->unique()->safeEmail(),
            'gender' => fake()->numberBetween(0, 1),
            'phone_number' => fake()->unique()->phoneNumber(),
            'address' => fake()->unique()->address(),
            'bio' => fake()->jobTitle()
        ];
    }
}

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
            // Book name
            'name' => $this->faker->sentence(3),
            'value' => $this->faker->randomFloat(2, 0, 1000),
            'isbn' => $this->faker->isbn13,
        ];
    }
}

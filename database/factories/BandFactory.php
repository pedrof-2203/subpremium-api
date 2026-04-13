<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Band>
 */
class BandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company().' '.$this->faker->randomElement(['Project', 'Experience', 'Quartet']),
            'country' => $this->faker->country(),
            'genres' => ['Rock', 'Indie', 'Alternative'], // Casted to array in Model
            'formed_at' => $this->faker->date(),
            'disbanded_at' => $this->faker->optional(0.2)->date(), // 20% chance of being disbanded
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'country' => $this->faker->country(),
            'birthday' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'genres' => $this->faker->randomElements(['Vocalist', 'Guitarist', 'Drummer', 'Bassist'], 2),
            'band_id' => null, // Typically set by the Seeder
        ];
    }
}

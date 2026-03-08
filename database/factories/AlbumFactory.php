<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucwords($this->faker->words(3, true)),
            'description' => $this->faker->sentence(15),
            'genres' => $this->faker->randomElements(['Rock', 'Jazz', 'Pop', 'Metal', 'Lo-fi'], 2),
            'release_date' => $this->faker->date(),
            'artist_id' => null,
            'band_id' => null,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(rand(1, 4), true),
            'description' => $this->faker->paragraph(1),
            'genres' => $this->faker->randomElements(['Acoustic', 'Electric', 'Live', 'Studio'], 1),
            'release_date' => $this->faker->date(),
            'album_id' => null,
            'artist_id' => null,
            'band_id' => null,
        ];
    }
}

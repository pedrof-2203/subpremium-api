<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Band;
use App\Models\Song;
use Illuminate\Database\Seeder;

class MusicDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 Bands, each with 3 Artists
        Band::factory(5)->create()->each(function ($band) {

            // Create Artists for this band
            Artist::factory(3)->create([
                'band_id' => $band->id,
                'country' => $band->country, // Keep them in the same country for realism
            ]);

            // Create 2 Albums for the band
            Album::factory(2)->create([
                'band_id' => $band->id,
            ])->each(function ($album) use ($band) {

                // Create 10 Songs for each album
                Song::factory(10)->create([
                    'album_id' => $album->id,
                    'band_id' => $band->id,
                ]);
            });
        });

        // Create some Solo Artists (not in a band)
        Artist::factory(5)->create(['band_id' => null])->each(function ($artist) {
            Album::factory(1)->create(['artist_id' => $artist->id])->each(function ($album) use ($artist) {
                Song::factory(5)->create([
                    'album_id' => $album->id,
                    'artist_id' => $artist->id,
                ]);
            });
        });
    }
}

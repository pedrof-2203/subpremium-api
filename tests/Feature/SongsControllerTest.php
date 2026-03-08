<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Band;
use App\Models\Song;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SongsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_songs()
    {
        Song::factory()->count(3)->create();

        $response = $this->getJson('/api/songs');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_can_show_a_specific_song()
    {
        $song = Song::factory()->create(['title' => 'Bohemian Rhapsody']);

        $response = $this->getJson("/api/songs/{$song->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.titulo', 'Bohemian Rhapsody');
    }

    #[Test]
    public function it_can_create_a_song_linked_to_an_album()
    {
        // Criando as dependências para passar na validação 'exists'
        $artist = Artist::factory()->create();
        $album = Album::factory()->create(['artist_id' => $artist->id]);

        $data = [
            'artist_id' => $artist->id,
            'album_id' => $album->id,
            'title' => 'Starman',
            'description' => 'A classic David Bowie song',
            'genres' => ['Glam Rock', 'Space Rock'],
            'release_date' => '1972-04-28',
        ];

        $response = $this->postJson('/api/songs', $data);

        $response->assertStatus(201)
                 ->assertJsonPath('data.titulo', 'Starman');
        $this->assertDatabaseHas('songs', ['title' => 'Starman']);
    }

    #[Test]
    public function it_fails_to_create_song_without_required_fields()
    {
        $response = $this->postJson('/api/songs', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'description', 'genres', 'release_date']);
    }

    #[Test]
    public function it_can_update_a_song()
    {
        $song = Song::factory()->create(['title' => 'Old Song Title']);

        $response = $this->putJson("/api/songs/{$song->id}", [
            'title' => 'New Song Title'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.titulo', 'New Song Title');

        $this->assertDatabaseHas('songs', ['title' => 'New Song Title']);
    }

    #[Test]
    public function it_can_delete_a_song()
    {
        $song = Song::factory()->create();

        $response = $this->deleteJson("/api/songs/{$song->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Song deleted successfully']);

        $this->assertDatabaseMissing('songs', ['id' => $song->id]);
    }
}
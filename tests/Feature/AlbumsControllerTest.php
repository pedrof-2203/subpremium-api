<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Band;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AlbumsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_albums()
    {
        Album::factory()->count(3)->create();

        $response = $this->getJson('/api/albums');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_can_show_a_specific_album()
    {
        $album = Album::factory()->create(['title' => 'Master of Puppets']);

        $response = $this->getJson("/api/albums/{$album->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.titulo', 'Master of Puppets');
    }

    #[Test]
    public function it_can_create_an_album_linked_to_a_band()
    {
        $band = Band::factory()->create();

        $data = [
            'band_id' => $band->id,
            'title' => 'Random Access Memories',
            'description' => 'A masterpiece by Daft Punk',
            'genres' => ['Electronic', 'Funk'],
            'release_date' => '2013-05-17',
        ];

        $response = $this->postJson('/api/albums', $data);

        $response->assertStatus(201); // Se o controller retornar 200
        $this->assertDatabaseHas('albums', ['title' => 'Random Access Memories']);
    }

    #[Test]
    public function it_fails_to_create_album_without_required_fields()
    {
        $response = $this->postJson('/api/albums', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'description', 'genres', 'release_date']);
    }

    #[Test]
    public function it_can_update_an_album()
    {
        $album = Album::factory()->create(['title' => 'Old Title']);

        $response = $this->putJson("/api/albums/{$album->id}", [
            'title' => 'New Title'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.titulo', 'New Title');

        $this->assertDatabaseHas('albums', ['title' => 'New Title']);
    }

    #[Test]
    public function it_can_delete_an_album()
    {
        $album = Album::factory()->create();

        $response = $this->deleteJson("/api/albums/{$album->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Album deletado com sucesso']);

        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }
}
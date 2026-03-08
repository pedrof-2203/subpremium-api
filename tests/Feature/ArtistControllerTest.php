<?php

namespace Tests\Feature;

use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ArtistControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_artists()
    {
        Artist::factory()->count(3)->create();

        $response = $this->getJson('/api/artists');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_can_show_a_specific_artist()
    {
        $artist = Artist::factory()->create(['name' => 'Freddie Mercury']);

        $response = $this->getJson("/api/artists/{$artist->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.nome', 'Freddie Mercury');
    }

    #[Test]
    public function it_can_create_an_artist()
    {
        $data = [
            'name' => 'David Bowie',
            'country' => 'UK',
            'birthday' => '1947-01-08',
            'genres' => ['Art Rock', 'Glam Rock'],
        ];

        $response = $this->postJson('/api/artists', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('artists', ['name' => 'David Bowie']);
    }

    #[Test]
    public function it_fails_to_create_artist_without_required_fields()
    {
        $response = $this->postJson('/api/artists', []);

        // O Laravel retorna 422 para erros de validação
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'country', 'birthday', 'genres']);
    }

    #[Test]
    public function it_can_update_an_artist()
    {
        $artist = Artist::factory()->create(['name' => 'Original Name']);

        $response = $this->putJson("/api/artists/{$artist->id}", [
            'name' => 'Updated Name'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.nome', 'Updated Name');

        $this->assertDatabaseHas('artists', ['name' => 'Updated Name']);
    }

    #[Test]
    public function it_can_delete_an_artist()
    {
        $artist = Artist::factory()->create();

        $response = $this->deleteJson("/api/artists/{$artist->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Artist deleted successfully']);

        $this->assertDatabaseMissing('artists', ['id' => $artist->id]);
    }
}
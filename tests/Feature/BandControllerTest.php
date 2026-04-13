<?php

namespace Tests\Feature;

use App\Models\Band;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase; // Importante para evitar os avisos

class BandControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_bands()
    {
        Band::factory()->count(3)->create();
        $response = $this->getJson('/api/bands');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    #[Test]
    public function it_can_create_a_band()
    {
        $data = [
            'name' => 'Ghost',
            'country' => 'Sweden',
            'genres' => ['Occult Rock'],
            'formed_at' => '2006-01-01',
        ];

        // Agora o POST é direto na raiz /api/bands
        $response = $this->postJson('/api/bands', $data);

        $response->assertStatus(200); // Ou 201 se você alterou o controller
        $this->assertDatabaseHas('bands', ['name' => 'Ghost']);
    }

    #[Test]
    public function it_can_update_a_band()
    {
        $band = Band::factory()->create(['name' => 'Old Name']);

        // Agora o PUT é direto no ID /api/bands/{id}
        $response = $this->putJson("/api/bands/{$band->id}", [
            'name' => 'New Name',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('bands', ['name' => 'New Name']);
    }

    #[Test]
    public function it_can_delete_a_band()
    {
        // 1. Cria a banda
        $band = Band::factory()->create();

        // 2. Tenta deletar usando o ID real que o banco gerou
        $response = $this->deleteJson("/api/bands/{$band->id}");

        // 3. Verifica se o status foi sucesso
        $response->assertStatus(200);

        // 4. Verifica se o registro REALMENTE sumiu do banco
        $this->assertSoftDeleted('bands', [
            'id' => $band->id,
        ]);
    }
}

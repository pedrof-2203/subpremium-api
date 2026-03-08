<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'pais' => $this->country,
            'generos' => $this->genres,
            'aniversario' => $this->birthday?->format('d/m/Y'),
            'banda_id' => $this->band_id,
            'criado_em' => $this->created_at?->format('d/m/Y'),
            'atualizado_em' => $this->updated_at?->format('d/m/Y'),
        ];
    }
}

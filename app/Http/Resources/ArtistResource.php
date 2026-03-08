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
            'id'           => $this->id,
            'nome_artista'   => $this->name,
            'nascimento'   => $this->birthday ? $this->birthday->format('d/m/Y') : null,
            'pais'         => $this->country,
            'estilos'      => $this->genres,
            'criado_em'    => $this->created_at?->toDateTimeString(),
        ];
    }
}

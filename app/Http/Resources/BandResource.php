<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BandResource
 *
 * Transforms the raw Band model into a localized JSON representation.
 * Customizes field names to Portuguese (e.g., `nome_banda`, `fundada_em`) 
 * and handles date string formatting and derived properties (`ativa`).
 *
 * @mixin \App\Models\Band
 * @package App\Http\Resources
 */
class BandResource extends JsonResource
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
            'nome_banda'   => $this->name,
            'pais'         => $this->country,
            'estilos'      => $this->genres,
            'fundada_em'   => $this->formed_at ? $this->formed_at->format('d/m/Y') : null,
            'ativa'        => $this->disbanded_at ? false : true,
            'encerrada_em' => $this->disbanded_at ? $this->disbanded_at->format('d/m/Y') : 'Ainda ativa',
            'criado_em'    => $this->created_at?->toDateTimeString(),
        ];
    }
}

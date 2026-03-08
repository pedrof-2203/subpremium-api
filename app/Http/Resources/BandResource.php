<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'artista_id' => $this->artist_id,
            'banda_id' => $this->band_id,
            'album_id' => $this->album_id,
            'titulo' => $this->title,
            'descricao' => $this->description,
            'generos' => $this->genres,
            'data_lancamento' => $this->release_date?->format('d/m/Y'),
            'criado_em' => $this->created_at?->format('d/m/Y'),
            'atualizado_em' => $this->updated_at?->format('d/m/Y'),
        ];
    }
}

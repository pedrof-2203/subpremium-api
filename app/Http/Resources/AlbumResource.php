<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AlbumResource
 *
 * Transforms the raw Album model into a localized JSON representation.
 * Customizes field names to Portuguese (e.g., `banda_id`, `titulo`, `descricao`) 
 * and handles formatting for the client response payload.
 *
 * @mixin \App\Models\Album
 * @package App\Http\Resources
 */
class AlbumResource extends JsonResource
{
    /**
     * Transforma o recurso em um array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'banda_id' => $this->band_id,
            'artista_id' => $this->artist_id,
            'titulo' => $this->title,
            'descricao' => $this->description,
            'generos' => $this->genres, 
            
            'data_lancamento' => $this->release_date?->format('d/m/Y'),
            'criado_em' => $this->created_at?->format('d/m/Y H:i'),
            
            'banda' => $this->whenLoaded('band', function() {
                return $this->band->name;
            }),
        ];
    }
}
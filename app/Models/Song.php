<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Song
 * 
 * Represents a track or song in the domain.
 * A song typically belongs to an Album, and optionally to an Artist or a Band.
 *
 * @property int $id
 * @property int|null $artist_id
 * @property int|null $band_id
 * @property int|null $album_id
 * @property string $title
 * @property string|null $description
 * @property array|null $genres
 * @property \Illuminate\Support\Carbon|null $release_date
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read \App\Models\Album|null $album Relationship to the parent Album.
 * 
 * @package App\Models
 */
class Song extends Model
{
    use HasFactory;

    protected $fillable = ['artist_id', 'band_id', 'album_id', 'title', 'description', 'genres', 'release_date'];

    protected $casts = [
        'genres' => 'array',
        'release_date' => 'date',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}

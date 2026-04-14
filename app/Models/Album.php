<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Album
 * 
 * Represents a music album in the domain.
 * An album can be associated with either an Artist or a Band.
 *
 * @property int $id
 * @property int|null $artist_id
 * @property int|null $band_id
 * @property string $title
 * @property string|null $description
 * @property array|null $genres
 * @property \Illuminate\Support\Carbon|null $release_date
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * 
 * @package App\Models
 */
class Album extends Model
{
    use HasFactory;

    protected $fillable = ['artist_id', 'band_id', 'title', 'description', 'genres', 'release_date'];

    protected $casts = [
        'genres' => 'array',
        'release_date' => 'date',
    ];
}

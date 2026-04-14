<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Artist
 * 
 * Represents an individual artist or musician in the domain.
 * An artist may optionally be associated with a Band.
 *
 * @property int $id
 * @property string $name
 * @property string|null $country
 * @property array|null $genres
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property int|null $band_id
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * 
 * @package App\Models
 */
class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country', 'genres', 'birthday', 'band_id'];

    protected $casts = [
        'genres' => 'array',
        'birthday' => 'date',
    ];
}

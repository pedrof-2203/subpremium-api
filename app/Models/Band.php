<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Band
 * 
 * Represents a musical band or group in the domain.
 * Supports soft deletion.
 *
 * @property int $id
 * @property string $name
 * @property string|null $country
 * @property array|null $genres
 * @property \Illuminate\Support\Carbon|null $formed_at
 * @property \Illuminate\Support\Carbon|null $disbanded_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * 
 * @package App\Models
 */
class Band extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'country', 'genres', 'formed_at', 'disbanded_at'];

    protected $casts = [
        'genres' => 'array',
        'formed_at' => 'date',
        'disbanded_at' => 'date',
        'deleted_at' => 'date',
    ];
}

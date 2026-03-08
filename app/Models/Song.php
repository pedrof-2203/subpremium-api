<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['artist_id', 'band_id', 'album_id', 'title', 'description', 'genres', 'release_date'];

    protected $casts = [
        'genres' => 'array',
        'release_date' => 'date',
    ];
}

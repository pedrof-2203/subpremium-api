<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory; 

    protected $fillable = ['artist_id', 'band_id', 'title', 'description', 'genres', 'release_date'];

    protected $casts = [
        'genres' => 'array',
        'formed_at' => 'date',
        'disbanded_at' => 'date',
    ];
}



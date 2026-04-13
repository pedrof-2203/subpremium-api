<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country', 'genres', 'birthday', 'band_id'];

    protected $casts = [
        'genres' => 'array',
        'birthday' => 'date',
    ];
}

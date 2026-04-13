<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumRating extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'album_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'favorite',
    ];

    protected $casts = [
        'album_id' => 'integer',
        'user_id' => 'integer',
        'rating' => 'integer',
        'title' => 'string',
        'comment' => 'string',
        'favorite' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album() 
    {
        return $this->belongsTo(Album::class);
    }
}

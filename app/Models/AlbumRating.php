<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AlbumRating
 * 
 * Represents a user's rating and review for a specific Album.
 * Supports soft deletion.
 *
 * @property int $id
 * @property int $album_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $title
 * @property string|null $comment
 * @property bool $favorite
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read \App\Models\User $user The user who created the rating.
 * @property-read \App\Models\Album $album The album being rated.
 * 
 * @package App\Models
 */
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

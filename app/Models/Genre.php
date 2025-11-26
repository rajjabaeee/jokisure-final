<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasUuids;

    protected $table = 'genre';
    protected $primaryKey = 'genre_id';
    public $timestamps = false;

    protected $fillable = [
        'genre_name'
    ];

    /**
     * Get the games in this genre
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'game_genre',
            'genre_id',
            'game_id'
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasUuids;

    protected $table = 'game';
    protected $primaryKey = 'game_id';
    public $timestamps = false;

    protected $fillable = [
        'game_name',
        'release_date',
        'game_desc',
        'device_id',
        'game_rating'
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'game_rating' => 'integer'
        ];
    }

    /**
     * Get the device this game is available on
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id', 'device_id');
    }

    /**
     * Get the genres for this game
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            Genre::class,
            'game_genre',
            'game_id',
            'genre_id'
        );
    }

    /**
     * Get the services for this game
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'game_id', 'game_id');
    }
}

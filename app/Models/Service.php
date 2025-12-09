<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasUuids;

    protected $table = 'service';
    protected $primaryKey = 'service_id';
    public $timestamps = false;

    protected $fillable = [
        'booster_id',
        'game_id',
        'service_name',
        'service_price',
        'service_desc',
        'est_time',
        'service_rating'
    ];

    protected function casts(): array
    {
        return [
            'service_price' => 'integer',
            'service_rating' => 'integer'
        ];
    }

    /**
     * Get the booster offering this service
     */
    public function booster(): BelongsTo
    {
        return $this->belongsTo(Booster::class, 'booster_id', 'booster_id');
    }

    /**
     * Get the game for this service
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id', 'game_id');
    }

    /**
     * Get the reviews for this service
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'service_id', 'service_id');
    }

    /**
     * Get the order items for this service
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'service_id', 'service_id');
    }

    /**
     * Get the cart items for this service
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'service_id', 'service_id');
    }
}

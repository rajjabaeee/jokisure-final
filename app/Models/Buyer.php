<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Buyer extends Model
{
    use HasUuids;

    protected $table = 'buyer';
    protected $primaryKey = 'buyer_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'cart_id'
    ];

    /**
     * Get the user that owns this buyer
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the order items for this buyer
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'buyer_id', 'buyer_id');
    }

    /**
     * Get the payments for this buyer
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'buyer_id', 'buyer_id');
    }

    /**
     * Get the reviews written by this buyer
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'buyer_id', 'buyer_id');
    }

    /**
     * Get the coupons/discounts for this buyer
     */
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(
            Discount::class,
            'buyer_coupons',
            'buyer_id',
            'discount_id'
        )->withPivot('coupons_used');
    }

    /**
     * Get cart items for this buyer
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }
}

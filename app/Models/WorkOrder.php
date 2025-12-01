<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkOrder extends Model
{
    use HasUuids;

    protected $table = 'work_order';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = [
        'boost_priority_id',
        'order_date',
        'order_status_id',
        'subtotal_amount',
        'discount_id',
        'discount_amount',
        'total_amount'
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'datetime',
            'subtotal_amount' => 'integer',
            'discount_amount' => 'integer',
            'total_amount' => 'integer'
        ];
    }

    /**
     * Get the boost priority for this order
     */
    public function boostPriority(): BelongsTo
    {
        return $this->belongsTo(BoostPriority::class, 'boost_priority_id', 'boost_priority_id');
    }

    /**
     * Get the order status for this order
     */
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'order_status_id');
    }

    /**
     * Get the discount applied to this order
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'discount_id');
    }

    /**
     * Get the order items for this order
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    /**
     * Get the payments for this order
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id', 'order_id');
    }

    /**
     * Get timeline events for this order
     */
    public function events(): HasMany
    {
        return $this->hasMany(WorkOrderEvent::class, 'order_id', 'order_id');
    }
}

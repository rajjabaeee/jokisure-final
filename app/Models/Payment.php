<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasUuids;

    protected $table = 'payment';
    protected $primaryKey = 'payment_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'buyer_id',
        'method_id',
        'payment_status_id',
        'gateway_reference',
        'latest_update'
    ];

    protected function casts(): array
    {
        return [
            'latest_update' => 'datetime'
        ];
    }

    /**
     * Get the work order for this payment
     */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'order_id', 'order_id');
    }

    /**
     * Get the buyer for this payment
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'buyer_id');
    }

    /**
     * Get the payment method for this payment
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id', 'method_id');
    }

    /**
     * Get the payment status for this payment
     */
    public function paymentStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'payment_status_id', 'order_status_id');
    }

    /**
     * Get the payment instructions for this payment
     */
    public function instructions(): HasMany
    {
        return $this->hasMany(PaymentInstruction::class, 'payment_id', 'payment_id');
    }

    /**
     * Get the receipt for this payment
     */
    public function receipt(): HasMany
    {
        return $this->hasMany(Receipt::class, 'payment_id', 'payment_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasUuids;

    protected $table = 'order_items';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'buyer_id',
        'service_id',
        'quantity',
        'item_subtotal',
        'game_username',
        'game_password_encrypt'
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'item_subtotal' => 'integer'
        ];
    }

    /**
     * Get the work order associated with this item
     */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'order_id', 'order_id');
    }

    /**
     * Get the buyer associated with this item
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'buyer_id');
    }

    /**
     * Get the service associated with this item
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatus extends Model
{
    use HasUuids;

    protected $table = 'order_status';
    protected $primaryKey = 'order_status_id';
    public $timestamps = false;

    protected $fillable = [
        'order_status_name'
    ];

    /**
     * Get the work orders with this status
     */
    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class, 'order_status_id', 'order_status_id');
    }

    /**
     * Get the payments with this status
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'payment_status_id', 'order_status_id');
    }
}

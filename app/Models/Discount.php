<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasUuids;

    protected $table = 'discount';
    protected $primaryKey = 'discount_id';
    public $timestamps = false;

    protected $fillable = [
        'discount_name',
        'discount_desc',
        'min_transaction',
        'discount_value',
        'discount_created',
        'discount_end',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'discount_created' => 'date',
            'discount_end' => 'date',
            'is_active' => 'boolean',
            'min_transaction' => 'integer'
        ];
    }

    /**
     * Get the work orders using this discount
     */
    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class, 'discount_id', 'discount_id');
    }

    /**
     * Get the buyers who have this coupon
     */
    public function buyers()
    {
        return $this->belongsToMany(
            Buyer::class,
            'buyer_coupons',
            'discount_id',
            'buyer_id'
        )->withPivot('coupons_used');
    }
}

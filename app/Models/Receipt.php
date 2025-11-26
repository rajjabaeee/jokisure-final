<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    use HasUuids;

    protected $table = 'receipt';
    protected $primaryKey = 'receipt_id';
    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'is_verified',
        'latest_update'
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'latest_update' => 'datetime'
        ];
    }

    /**
     * Get the payment for this receipt
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }
}

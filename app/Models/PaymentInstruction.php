<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentInstruction extends Model
{
    use HasUuids;

    protected $table = 'payment_instruction';
    protected $primaryKey = 'instruction_id';
    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'payment_to',
        'expires_at'
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime'
        ];
    }

    /**
     * Get the payment for this instruction
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }
}

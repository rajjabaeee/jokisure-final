<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasUuids;

    protected $table = 'payment_method';
    protected $primaryKey = 'method_id';
    public $timestamps = false;

    protected $fillable = [
        'method_name',
        'admin_fee',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'admin_fee' => 'integer',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Get the payments using this method
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'method_id', 'method_id');
    }
}

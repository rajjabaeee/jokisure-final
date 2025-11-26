<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoostPriority extends Model
{
    use HasUuids;

    protected $table = 'boost_priority';
    protected $primaryKey = 'boost_priority_id';
    public $timestamps = false;

    protected $fillable = [
        'boost_priority_name'
    ];

    /**
     * Get the work orders with this priority
     */
    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class, 'boost_priority_id', 'boost_priority_id');
    }
}

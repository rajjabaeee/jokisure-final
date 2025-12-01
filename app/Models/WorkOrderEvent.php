<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderEvent extends Model
{
    use HasUuids;

    protected $table = 'work_order_events';
    protected $primaryKey = 'event_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'event_type',
        'description',
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime'
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'order_id', 'order_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasUuids;

    protected $table = 'review';
    protected $primaryKey = 'review_id';
    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'buyer_id',
        'user_rating',
        'user_review'
    ];

    protected function casts(): array
    {
        return [
            'user_rating' => 'integer'
        ];
    }

    /**
     * Get the service being reviewed
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    /**
     * Get the buyer who wrote the review
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'buyer_id');
    }
}

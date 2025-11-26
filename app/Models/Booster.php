<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booster extends Model
{
    use HasUuids;

    protected $table = 'booster';
    protected $primaryKey = 'booster_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'booster_desc',
        'work_start',
        'work_end',
        'verified',
        'booster_rating',
        'booster_satisfaction',
        'past_buyers'
    ];

    protected function casts(): array
    {
        return [
            'verified' => 'boolean',
            'booster_rating' => 'integer',
            'booster_satisfaction' => 'integer',
            'past_buyers' => 'integer'
        ];
    }

    /**
     * Get the user associated with this booster
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the services offered by this booster
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'booster_id', 'booster_id');
    }

    /**
     * Get the tags associated with this booster
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            SellerTag::class,
            'booster_tag',
            'booster_id',
            'seller_tag_id'
        );
    }
}

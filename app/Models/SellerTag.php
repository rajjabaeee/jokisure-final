<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SellerTag extends Model
{
    use HasUuids;

    protected $table = 'seller_tag';
    protected $primaryKey = 'seller_tag_id';
    public $timestamps = false;

    protected $fillable = [
        'seller_tag_name'
    ];

    /**
     * Get the boosters with this tag
     */
    public function boosters(): BelongsToMany
    {
        return $this->belongsToMany(
            Booster::class,
            'booster_tag',
            'seller_tag_id',
            'booster_id'
        );
    }
}

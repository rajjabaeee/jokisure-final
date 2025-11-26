<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasUuids;

    protected $table = 'device';
    protected $primaryKey = 'device_id';
    public $timestamps = false;

    protected $fillable = [
        'device_name'
    ];

    /**
     * Get the games for this device
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'device_id', 'device_id');
    }
}

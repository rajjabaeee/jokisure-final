<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'user_name',
        'user_nametag',
        'user_password_hash',
        'user_number',
        'user_profile_pic',
        'user_email',
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'user_profile_pic' => 'binary'
        ];
    }

    /**
     * Get the buyer associated with the user
     */
    public function buyer(): HasOne
    {
        return $this->hasOne(Buyer::class, 'user_id', 'user_id');
    }

    /**
     * Get the booster associated with the user
     */
    public function booster(): HasOne
    {
        return $this->hasOne(Booster::class, 'user_id', 'user_id');
    }

    /**
     * Get the chats sent by this user
     */
    public function sentChats(): HasMany
    {
        return $this->hasMany(Chat::class, 'sender_user_id', 'user_id');
    }

    /**
     * Get the chats received by this user
     */
    public function receivedChats(): HasMany
    {
        return $this->hasMany(Chat::class, 'receiver_user_id', 'user_id');
    }
}

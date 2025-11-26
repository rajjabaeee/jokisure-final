<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasUuids;

    protected $table = 'chat';
    protected $primaryKey = 'chat_id';
    public $timestamps = false;

    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'chat_msg',
        'send_date',
        'receive_date'
    ];

    protected function casts(): array
    {
        return [
            'send_date' => 'datetime',
            'receive_date' => 'datetime'
        ];
    }

    /**
     * Get the sender of this message
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id', 'user_id');
    }

    /**
     * Get the receiver of this message
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_user_id', 'user_id');
    }
}

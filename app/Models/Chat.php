<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

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

    protected $casts = [
        'send_date' => 'datetime',
        'receive_date' => 'datetime',
    ];

    // Supaya Blade tetap bisa pakai ->created_at
    protected $appends = ['created_at'];

    public function getCreatedAtAttribute()
    {
        // created_at = send_date
        return $this->send_date ? Carbon::parse($this->send_date) : null;
    }

    /**
     * Sender
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id', 'user_id');
    }

    /**
     * Receiver
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_user_id', 'user_id');
    }
}
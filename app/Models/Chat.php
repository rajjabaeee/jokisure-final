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
        'send_date'   => 'datetime',
        'receive_date'=> 'datetime',
    ];

    // Supaya Blade bisa pakai ->created_at (di-mapping ke send_date)
    protected $appends = ['created_at'];

    public function getCreatedAtAttribute()
    {
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

    /**
     * Helper: ambil last chat antara dua user
     */
    public static function lastBetween(string $userAId, string $userBId): ?self
    {
        return self::where(function ($q) use ($userAId, $userBId) {
                    $q->where('sender_user_id', $userAId)
                      ->where('receiver_user_id', $userBId);
                })
                ->orWhere(function ($q) use ($userAId, $userBId) {
                    $q->where('sender_user_id', $userBId)
                      ->where('receiver_user_id', $userAId);
                })
                ->orderByDesc('send_date')
                ->first();
    }
}

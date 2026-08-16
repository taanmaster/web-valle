<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sent_by',
        'subject',
        'body',
        'read_at',
        'related_model_type',
        'related_model_id',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function related()
    {
        return $this->morphTo(__FUNCTION__, 'related_model_type', 'related_model_id');
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function markAsRead(): void
    {
        if (! $this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }
}

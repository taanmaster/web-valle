<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanBajioNotification extends Model
{
    use HasFactory;

    protected $table = 'banbajio_notifications';

    protected $guarded = [];

    protected $casts = [
        'hash_valid' => 'boolean',
        'raw_payload' => 'array',
        'processed_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
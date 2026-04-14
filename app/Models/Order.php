<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'total'        => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'paid_at'      => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateFolio(): string
    {
        do {
            $folio = strtoupper(substr(uniqid(), -10));
        } while (static::where('folio', $folio)->exists());

        return $folio;
    }
}

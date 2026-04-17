<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillableService extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function billableService()
    {
        return $this->belongsTo(BillableService::class);
    }

    /** Nombre a mostrar: del catálogo o el snapshot ad-hoc. */
    public function getServiceLabelAttribute(): string
    {
        return $this->billableService->name ?? $this->service_name ?? 'Servicio';
    }

    /** Precio unitario: del catálogo o el snapshot ad-hoc. */
    public function getUnitPriceValueAttribute(): float
    {
        return (float) ($this->billableService->unit_price ?? $this->unit_price ?? 0);
    }

    public function getSubtotalAttribute()
    {
        return $this->unit_price_value * $this->quantity;
    }
}

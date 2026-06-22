<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrbanDevCost extends Model
{
    protected $fillable = [
        'tramite_slug',
        'tramite_title',
        'description',
        'amount',
        'unit',
        'position',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'position' => 'integer',
    ];

    /**
     * Precio formateado tal como se muestra en el front: "$771.84" o "$692.31 x m2".
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format((float) $this->amount, 2) . ($this->unit ? ' ' . $this->unit : '');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketCut extends Model
{
    use HasFactory;

    protected $fillable = [
        'cut_date',
        'created_by',
        'tickets_count',
        'system_total',
        'cash_counted',
        'treasury_received_by',
        'notes',
    ];

    protected $casts = [
        'cut_date' => 'date',
        'system_total' => 'decimal:2',
        'cash_counted' => 'decimal:2',
    ];

    public function tickets()
    {
        return $this->hasMany(MarketTicket::class)->orderBy('series')->orderBy('folio');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDifferenceAttribute(): float
    {
        return round((float) $this->cash_counted - (float) $this->system_total, 2);
    }
}

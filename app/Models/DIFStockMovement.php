<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFStockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_id',
        'movement_type',
        'quantity',
        'date',
        'expiration_date',
        'external_reference',
    'additional_info',
    'parent_id',
    'movement_sub_type',
    ];

    protected $casts = [
        'additional_info' => 'array',
        'date' => 'date',
        'expiration_date' => 'date',
    ];

    public function variant()
    {
        return $this->belongsTo(DIFMedicationVariant::class, 'variant_id');
    }

    /**
     * Movimiento padre (entrada) al que puede estar vinculada una salida.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Salidas que consumen esta entrada.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}

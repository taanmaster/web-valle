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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFPaymentConcept extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_payment_concepts';

    protected $fillable = [
        'name',
        'description',
        'amount',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
    ];

    // Relación con recibos a través de la tabla pivot
    public function receipts()
    {
        return $this->belongsToMany(DIFReceipt::class, 'd_i_f_receipt_concepts', 'concept_id', 'receipt_id');
    }
}

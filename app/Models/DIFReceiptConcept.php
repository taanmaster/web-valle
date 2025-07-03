<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFReceiptConcept extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'receipt_id',
        'concept_id',
    ];

    // Relación con el recibo
    public function receipt()
    {
        return $this->belongsTo(DIFReceipt::class, 'receipt_id');
    }

    // Relación con el concepto de pago
    public function paymentConcept()
    {
        return $this->belongsTo(DIFPaymentConcept::class, 'concept_id');
    }
}

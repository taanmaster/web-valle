<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFReceipt extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_receipts';

    protected $fillable = [
        'receipt_num',
        'receipt_date',
        'pacient_id',
        'doctor_id',
        'appointment',
        'location',
        'subtotal',
        'discount',
        'total',
        'payment_method',
        'issued_by',
        'status',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relación con conceptos de pago a través de la tabla pivot
    public function paymentConcepts()
    {
        return $this->belongsToMany(DIFPaymentConcept::class, 'd_i_f_receipt_concepts', 'receipt_id', 'concept_id');
    }

    // Relación con la tabla pivot
    public function receiptConcepts()
    {
        return $this->hasMany(DIFReceiptConcept::class, 'receipt_id');
    }

    // Relación con el doctor
    public function doctor()
    {
        return $this->belongsTo(DIFDoctor::class, 'doctor_id');
    }

    // Relación con el paciente (citizen)
    public function patient()
    {
        return $this->belongsTo(Citizen::class, 'pacient_id');
    }
}

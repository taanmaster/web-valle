<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFPrescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_num',
        'doctor_id',
        'patient_id',
        'status',
        'prescription_date',
    ];

    protected $casts = [
        'prescription_date' => 'date',
    ];

    public function doctor()
    {
        return $this->belongsTo(DIFDoctor::class, 'doctor_id');
    }
}

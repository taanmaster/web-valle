<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFDoctor extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_doctors';

    protected $fillable = [
        'employee_num',
        'name',
        'specialty_id',
        'full_address',
        'email',
        'phone',
    ];

    public function specialty()
    {
        return $this->belongsTo(DIFSpecialty::class, 'specialty_id');
    }

    public function consultations()
    {
        return $this->hasMany(DIFDoctorConsult::class, 'doctor_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(DIFPrescription::class, 'doctor_id');
    }

    public function receipts()
    {
        return $this->hasMany(DIFReceipt::class, 'doctor_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFDoctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_num',
        'name',
        'specialty_id',
        'full_address',
        'email',
        'phone',
    ];

    public function speciality()
    {
        return $this->belongsTo(DIFSpecialty::class, 'specialty_id');
    }

    public function consultations()
    {
        return $this->hasMany(DIFDoctorConsult::class, 'doctor_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(DIFPrescriptionFile::class, 'doctor_id');
    }
}

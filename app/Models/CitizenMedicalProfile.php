<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenMedicalProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_id',
        'medical_num',
        'blood_type',
        'allergies',
        'medical_conditions',
        'medications',
        'gender',
        'age',
        'phone',
        'email',
    ];

    // Relación con ciudadano
    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }

    // Relación many-to-many con programas
    public function programs()
    {
        return $this->belongsToMany(DIFProgram::class, 'medical_profile_programs', 'medical_profile_id', 'program_id');
    }

    // Relación con la tabla pivot
    public function medicalProfilePrograms()
    {
        return $this->hasMany(MedicalProfileProgram::class, 'medical_profile_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalProfileProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_profile_id',
        'program_id',
    ];

    // Relación con perfil médico
    public function medicalProfile()
    {
        return $this->belongsTo(CitizenMedicalProfile::class, 'medical_profile_id');
    }

    // Relación con programa
    public function program()
    {
        return $this->belongsTo(DIFProgram::class, 'program_id');
    }
}

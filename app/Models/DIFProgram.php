<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFProgram extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_programs';

    protected $fillable = [
        'name',
        'description',
    'full_address',
    'manager',
    'start_date',
    'end_date',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación many-to-many con coordinaciones
    public function coordinations()
    {
        return $this->belongsToMany(DIFCoordination::class, 'd_i_f_coordination_programs', 'program_id', 'coordination_id');
    }

    // Relación many-to-many con perfiles médicos
    public function medicalProfiles()
    {
        return $this->belongsToMany(CitizenMedicalProfile::class, 'medical_profile_programs', 'program_id', 'medical_profile_id');
    }
}

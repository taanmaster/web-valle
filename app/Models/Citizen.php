<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(CitizenFile::class);
    }

    public function supports()
    {
        return $this->hasMany(FinancialSupport::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(DIFPrescription::class, 'patient_id');
    }

    public function medicalProfile()
    {
        return $this->hasOne(CitizenMedicalProfile::class);
    }

    public function summons()
    {
        return $this->hasMany(Summon::class);
    }
}

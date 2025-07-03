<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFDoctorConsult extends Model
{
    use HasFactory;

    public function doctor()
    {
        return $this->belongsTo(DIFDoctor::class, 'doctor_id');
    }
}

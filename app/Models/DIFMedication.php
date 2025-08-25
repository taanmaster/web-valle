<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFMedication extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_medications';

    protected $fillable = [
        'generic_name',
        'commercial_name',
        'description',
        'formula',
        'type',
        'type_num',
        'type_dosage',
        'use_type',
        'expiration_date',
        'is_active',
    ];
}

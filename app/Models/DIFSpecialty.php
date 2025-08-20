<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFSpecialty extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_specialties';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

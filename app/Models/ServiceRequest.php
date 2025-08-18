<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dependency_name',
        'description',
        'requirements',
        'cost',
        'steps_filename',
        'procedure_filename',
    ];
}

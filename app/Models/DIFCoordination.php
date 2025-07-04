<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFCoordination extends Model
{
    use HasFactory;
    
    protected $table = 'd_i_f_coordinations';
    
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación many-to-many con programas
    public function programs()
    {
        return $this->belongsToMany(DIFProgram::class, 'd_i_f_coordination_programs', 'coordination_id', 'program_id');
    }

    // Relación con la tabla pivot
    public function coordinationPrograms()
    {
        return $this->hasMany(DIFCoordinationProgram::class, 'coordination_id');
    }
}

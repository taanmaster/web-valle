<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFCoordinationProgram extends Model
{
    use HasFactory;
    
    protected $table = 'd_i_f_coordination_programs';
    
    protected $fillable = [
        'coordination_id',
        'program_id',
    ];

    // Relación con la coordinación
    public function coordination()
    {
        return $this->belongsTo(DIFCoordination::class, 'coordination_id');
    }

    // Relación con el programa
    public function program()
    {
        return $this->belongsTo(DIFProgram::class, 'program_id');
    }
}

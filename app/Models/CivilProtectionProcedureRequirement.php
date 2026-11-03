<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilProtectionProcedureRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'civil_protection_procedure_id',
        'sort_order',
        'name',
        'instructions',
        'is_required',
        'formats',
        'requires_original',
        'is_fixed',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'formats' => 'array',
        'requires_original' => 'boolean',
        'is_fixed' => 'boolean',
    ];

    public function procedure()
    {
        return $this->belongsTo(CivilProtectionProcedure::class, 'civil_protection_procedure_id');
    }
}

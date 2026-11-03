<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilProtectionProcedure extends Model
{
    use HasFactory;

    public const TYPES = [
        'technical_opinion' => 'Opinión técnica',
        'permit' => 'Permiso',
    ];

    /**
     * Requisito precargado en todos los trámites
     */
    public const FIXED_REQUIREMENT = [
        'name' => 'Oficio de petición',
        'instructions' => 'Dirigido a la Coordinación de Protección Civil, con firma',
        'is_required' => true,
        'formats' => ['pdf'],
        'requires_original' => true,
        'is_fixed' => true,
    ];

    protected $fillable = [
        'name',
        'type',
        'description',
        'folio_prefix',
        'validity_days',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function requirements()
    {
        return $this->hasMany(CivilProtectionProcedureRequirement::class)->orderBy('sort_order');
    }

    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function cases()
    {
        return $this->hasMany(CivilProtectionCase::class);
    }

    /**
     * El prefijo de folio se bloquea cuando ya existen expedientes del trámite
     */
    public function hasFiles(): bool
    {
        return $this->cases()->exists();
    }
}

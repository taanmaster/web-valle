<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrbanDevWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        's3_asset_url',
        'filesize',
        'employee_number',
        'name',
        'last_name',
        'issue_date',
        'validity_date_start',
        'validity_date_end',
        'position',
        'email',
        'phone',
        'extension',
        'dependency_category',
        'dependency_subcategory',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'validity_date_start' => 'date',
        'validity_date_end' => 'date',
    ];

    /**
     * Obtener el nombre completo del trabajador
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    /**
     * Scope para filtrar por categoría de dependencia
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('dependency_category', $category);
    }

    /**
     * Scope para filtrar por subcategoría de dependencia
     */
    public function scopeBySubcategory($query, $subcategory)
    {
        return $query->where('dependency_subcategory', $subcategory);
    }

    /**
     * Scope para inspectores (Desarrollo Urbano - Inspectores)
     */
    public function scopeInspectors($query)
    {
        return $query->where('dependency_category', 'Desarrollo Urbano')
                     ->where('dependency_subcategory', 'Inspector');
    }

    /**
     * Scope para peritos (Desarrollo Urbano - Peritos)
     */
    public function scopeExperts($query)
    {
        return $query->where('dependency_category', 'Desarrollo Urbano')
                     ->where('dependency_subcategory', 'Perito');
    }

    /**
     * Scope para fiscalización (Fiscalización)
     */
    public function scopeAuditors($query)
    {
        return $query->where('dependency_category', 'Fiscalización');
    }

    /**
     * Scope para fiscalización (Fiscalización)
     */
    public function scopeCivilDefense($query)
    {
        return $query->where('dependency_category', 'Protección Civil');
    }

    public function summons()
    {
        return $this->hasMany(Summon::class, 'worker_id');
    }
}

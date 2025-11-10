<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierEndorsement extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'endorsement_type',
        'endorsement_date',
        'filename',
        'filepath',
        'comments',
        'is_approved',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'endorsement_date' => 'date',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que creó el refrendo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el proveedor
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    /**
     * Relación con el usuario que aprobó
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Obtiene la URL del archivo en S3
     */
    public function getS3UrlAttribute()
    {
        if ($this->filepath) {
            return \Storage::disk('s3')->url($this->filepath);
        }
        return null;
    }

    /**
     * Obtiene el badge de estado de aprobación
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->is_approved) {
            return '<span class="badge bg-success">Aprobado</span>';
        }
        return '<span class="badge bg-warning">Pendiente de Aprobación</span>';
    }

    /**
     * Obtiene el año del refrendo
     */
    public function getYearAttribute()
    {
        return $this->endorsement_date ? $this->endorsement_date->format('Y') : null;
    }

    /**
     * Scope para filtrar por año
     */
    public function scopeByYear($query, $year)
    {
        return $query->whereYear('endorsement_date', $year);
    }

    /**
     * Scope para refrendos aprobados
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope para refrendos pendientes
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}


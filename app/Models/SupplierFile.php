<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'filename',
        'filepath',
        'file_type',
        'status',
        'comments',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

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
     * Obtiene el badge de estado
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pendiente' => '<span class="badge bg-warning">Pendiente</span>',
            'aprobado' => '<span class="badge bg-success">Aprobado</span>',
            'rechazado' => '<span class="badge bg-danger">Rechazado</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-secondary">Desconocido</span>';
    }

    /**
     * Verifica si el archivo está aprobado
     */
    public function isApproved()
    {
        return $this->status === 'aprobado';
    }

    /**
     * Verifica si el archivo está rechazado
     */
    public function isRejected()
    {
        return $this->status === 'rechazado';
    }

    /**
     * Verifica si el archivo está pendiente
     */
    public function isPending()
    {
        return $this->status === 'pendiente';
    }
}


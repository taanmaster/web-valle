<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackofficeDependency extends Model
{
    use HasFactory;

    protected $table = 'backoffice_dependencies';

    protected $fillable = [
        'code',
        'name',
        'responsible_name',
        'type',
    ];

    /**
     * Relación: Una dependencia tiene muchos documentos/oficios
     */
    public function documents()
    {
        return $this->hasMany(BackofficeDocument::class, 'dependency_id');
    }

    /**
     * Relación: Una dependencia tiene muchos usuarios asignados
     */
    public function users()
    {
        return $this->hasMany(User::class, 'backoffice_dependency_id');
    }

    /**
     * Relación: Una dependencia tiene muchos trámites de citas
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'backoffice_dependency_id');
    }

    /**
     * Accessor: Obtener código formateado en mayúsculas
     */
    public function getFormattedCodeAttribute()
    {
        return strtoupper($this->code);
    }
}

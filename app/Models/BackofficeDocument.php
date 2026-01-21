<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class BackofficeDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'backoffice_documents';

    protected $fillable = [
        'folio',
        'dependency_id',
        'user_id',
        'issue_date',
        'subject',
        'sender',
        'body',
        'requester',
        'priority',
        'type',
        'status',
        'signature_filename',
        'signature_s3_url',
        'stamp_filename',
        'stamp_s3_url',
        'validations_count',
        'first_read_at',
        'assigned_to',
        'assignment_message',
        'sent_to_user_id',
        'sent_at',
        'sent_message',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'first_read_at' => 'datetime',
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Generar folio único para el documento
     * Formato: CODE-DDMMYY-CONSECUTIVO
     */
    public static function generateFolio($dependencyId)
    {
        $dependency = BackofficeDependency::findOrFail($dependencyId);
        $code = strtoupper($dependency->code);
        $dateCode = Carbon::now()->format('dmy');
        
        // Buscar el último consecutivo del día para esta dependencia
        $lastDocument = self::where('dependency_id', $dependencyId)
            ->whereDate('issue_date', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastDocument) {
            // Extraer el consecutivo del último folio
            $parts = explode('-', $lastDocument->folio);
            $lastConsecutive = intval(end($parts));
            $consecutive = $lastConsecutive + 1;
        } else {
            $consecutive = 1;
        }
        
        return "{$code}-{$dateCode}-{$consecutive}";
    }

    /**
     * Relación: Documento pertenece a una dependencia
     */
    public function dependency()
    {
        return $this->belongsTo(BackofficeDependency::class, 'dependency_id');
    }

    /**
     * Relación: Documento creado por un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: Documento asignado a un colaborador
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relación: Documento enviado a un usuario destinatario
     */
    public function sentToUser()
    {
        return $this->belongsTo(User::class, 'sent_to_user_id');
    }

    /**
     * Relación: Documento tiene muchas versiones
     */
    public function versions()
    {
        return $this->hasMany(BackofficeDocumentVersion::class, 'document_id')->orderBy('created_at', 'desc');
    }

    /**
     * Relación: Documento tiene muchas validaciones
     */
    public function validations()
    {
        return $this->hasMany(BackofficeDocumentValidation::class, 'document_id');
    }

    /**
     * Verificar si el documento puede ser firmado (requiere mínimo 2 validaciones)
     */
    public function canBeSigned()
    {
        return $this->validations_count >= 2;
    }

    /**
     * Verificar si un usuario ya validó este documento
     */
    public function hasBeenValidatedBy($userId)
    {
        return $this->validations()->where('validator_id', $userId)->exists();
    }

    /**
     * Verificar si es la primera vez que el colaborador asignado ve el documento
     */
    public function isFirstRead()
    {
        return is_null($this->first_read_at);
    }

    /**
     * Accessor: Badge de prioridad con colores
     */
    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'urgente' => '<span class="badge bg-danger">Urgente</span>',
            'alta' => '<span class="badge bg-warning text-dark">Alta</span>',
            'baja' => '<span class="badge bg-info">Baja</span>',
        ];
        
        return $badges[$this->priority] ?? '<span class="badge bg-secondary">' . ucfirst($this->priority) . '</span>';
    }

    /**
     * Accessor: Label de prioridad
     */
    public function getPriorityLabelAttribute()
    {
        $labels = [
            'urgente' => 'Urgente',
            'alta' => 'Alta',
            'baja' => 'Baja',
        ];
        
        return $labels[$this->priority] ?? ucfirst($this->priority);
    }

    /**
     * Accessor: Badge de tipo con colores
     */
    public function getTypeBadgeAttribute()
    {
        $badges = [
            'solicitud' => '<span class="badge bg-primary">Solicitud</span>',
            'respuesta' => '<span class="badge bg-success">Respuesta</span>',
        ];
        
        return $badges[$this->type] ?? '<span class="badge bg-secondary">' . ucfirst($this->type) . '</span>';
    }

    /**
     * Accessor: Label de tipo
     */
    public function getTypeLabelAttribute()
    {
        $labels = [
            'solicitud' => 'Solicitud',
            'respuesta' => 'Respuesta',
        ];
        
        return $labels[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Accessor: Badge de status con colores
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'borrador' => '<span class="badge bg-secondary">Borrador</span>',
            'revision' => '<span class="badge bg-warning text-dark">En Revisión</span>',
            'validado' => '<span class="badge bg-info">Validado</span>',
            'firmado' => '<span class="badge bg-success">Firmado</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>';
    }

    /**
     * Accessor: Label de status
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'borrador' => 'Borrador',
            'revision' => 'En Revisión',
            'validado' => 'Validado',
            'firmado' => 'Firmado',
        ];
        
        return $labels[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Accessor: Porcentaje de progreso de validaciones
     */
    public function getValidationProgressAttribute()
    {
        return min(100, ($this->validations_count / 3) * 100);
    }

    /**
     * Scope: Documentos creados por un usuario
     */
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Documentos asignados a un usuario para revisión
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope: Filtrar por status
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Filtrar por prioridad
     */
    public function scopeWithPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope: Filtrar por tipo
     */
    public function scopeWithType($query, $type)
    {
        return $query->where('type', $type);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackofficeDocumentVersion extends Model
{
    use HasFactory;

    protected $table = 'backoffice_document_versions';

    protected $fillable = [
        'document_id',
        'activity_type',
        'activity_detail',
        'modified_field',
        'modified_by',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Tipos de actividad disponibles
     */
    const ACTIVITY_CREATED = 'creacion';
    const ACTIVITY_EDITED = 'edicion';
    const ACTIVITY_SENT_REVIEW = 'enviado_revision';
    const ACTIVITY_CONFIRMED_RECEIPT = 'confirmado_recibo';
    const ACTIVITY_CORRECTION_REQUESTED = 'correccion_solicitada';
    const ACTIVITY_VALIDATED = 'validado';
    const ACTIVITY_SIGNED = 'firmado';

    /**
     * Relación: Versión pertenece a un documento
     */
    public function document()
    {
        return $this->belongsTo(BackofficeDocument::class, 'document_id');
    }

    /**
     * Relación: Versión modificada por un usuario
     */
    public function modifiedByUser()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    /**
     * Accessor: Obtener las diferencias con la versión anterior
     */
    public function getChangesFromPreviousAttribute()
    {
        // Obtener la versión anterior
        $previousVersion = self::where('document_id', $this->document_id)
            ->where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
        
        if (!$previousVersion) {
            return []; // Es la primera versión, no hay cambios que comparar
        }
        
        $currentSnapshot = $this->snapshot ?? [];
        $previousSnapshot = $previousVersion->snapshot ?? [];
        
        $changes = [];
        
        // Campos a comparar
        $fieldsToCompare = [
            'subject' => 'Asunto',
            'sender' => 'Remitente',
            'body' => 'Cuerpo',
            'requester' => 'Solicitante',
            'priority' => 'Prioridad',
            'type' => 'Tipo',
            'status' => 'Estado',
        ];
        
        foreach ($fieldsToCompare as $field => $label) {
            $currentValue = $currentSnapshot[$field] ?? null;
            $previousValue = $previousSnapshot[$field] ?? null;
            
            if ($currentValue !== $previousValue) {
                $changes[$field] = [
                    'label' => $label,
                    'previous' => $previousValue,
                    'current' => $currentValue,
                ];
            }
        }
        
        return $changes;
    }

    /**
     * Accessor: Label del tipo de actividad
     */
    public function getActivityTypeLabelAttribute()
    {
        $labels = [
            self::ACTIVITY_CREATED => 'Creación',
            self::ACTIVITY_EDITED => 'Edición',
            self::ACTIVITY_SENT_REVIEW => 'Enviado a Revisión',
            self::ACTIVITY_CONFIRMED_RECEIPT => 'Confirmación de Recibo',
            self::ACTIVITY_CORRECTION_REQUESTED => 'Corrección Solicitada',
            self::ACTIVITY_VALIDATED => 'Validación',
            self::ACTIVITY_SIGNED => 'Firma',
        ];
        
        return $labels[$this->activity_type] ?? ucfirst(str_replace('_', ' ', $this->activity_type));
    }

    /**
     * Accessor: Badge del tipo de actividad
     */
    public function getActivityTypeBadgeAttribute()
    {
        $badges = [
            self::ACTIVITY_CREATED => '<span class="badge bg-primary">Creación</span>',
            self::ACTIVITY_EDITED => '<span class="badge bg-info">Edición</span>',
            self::ACTIVITY_SENT_REVIEW => '<span class="badge bg-warning text-dark">Enviado a Revisión</span>',
            self::ACTIVITY_CONFIRMED_RECEIPT => '<span class="badge bg-secondary">Recibo Confirmado</span>',
            self::ACTIVITY_CORRECTION_REQUESTED => '<span class="badge bg-danger">Corrección Solicitada</span>',
            self::ACTIVITY_VALIDATED => '<span class="badge bg-success">Validado</span>',
            self::ACTIVITY_SIGNED => '<span class="badge bg-dark">Firmado</span>',
        ];
        
        return $badges[$this->activity_type] ?? '<span class="badge bg-secondary">' . ucfirst($this->activity_type) . '</span>';
    }

    /**
     * Accessor: Traducir el nombre del campo modificado al español
     */
    public function getModifiedFieldLabelAttribute()
    {
        if (!$this->modified_field) {
            return null;
        }

        $fieldLabels = [
            'subject' => 'Asunto',
            'sender' => 'Remitente',
            'body' => 'Cuerpo del Oficio',
            'requester' => 'Solicitante',
            'priority' => 'Prioridad',
            'type' => 'Tipo',
            'status' => 'Estado',
            'assigned_to' => 'Asignado a',
            'assignment_message' => 'Mensaje de Asignación',
            'validations_count' => 'Validaciones',
            'folio' => 'Folio',
            'issue_date' => 'Fecha de Emisión',
        ];

        return $fieldLabels[$this->modified_field] ?? ucfirst(str_replace('_', ' ', $this->modified_field));
    }
}

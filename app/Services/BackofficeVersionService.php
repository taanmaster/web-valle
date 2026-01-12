<?php

namespace App\Services;

use App\Models\BackofficeDocument;
use App\Models\BackofficeDocumentVersion;
use Auth;

class BackofficeVersionService
{
    /**
     * Crear un snapshot del documento actual y registrar la versión
     *
     * @param BackofficeDocument $document
     * @param string $activityType Tipo de actividad realizada
     * @param string $activityDetail Descripción detallada de la actividad
     * @param string|null $modifiedField Campo específico modificado (opcional)
     * @return BackofficeDocumentVersion
     */
    public function createSnapshot(
        BackofficeDocument $document,
        string $activityType,
        string $activityDetail,
        ?string $modifiedField = null
    ): BackofficeDocumentVersion {
        // Crear snapshot del estado actual del documento
        $snapshot = $this->buildSnapshot($document);
        
        // Crear el registro de versión
        $version = BackofficeDocumentVersion::create([
            'document_id' => $document->id,
            'activity_type' => $activityType,
            'activity_detail' => $activityDetail,
            'modified_field' => $modifiedField,
            'modified_by' => Auth::id(),
            'snapshot' => $snapshot,
        ]);
        
        return $version;
    }

    /**
     * Construir el snapshot del documento
     *
     * @param BackofficeDocument $document
     * @return array
     */
    protected function buildSnapshot(BackofficeDocument $document): array
    {
        return [
            'folio' => $document->folio,
            'dependency_id' => $document->dependency_id,
            'dependency_code' => $document->dependency?->code,
            'dependency_name' => $document->dependency?->name,
            'user_id' => $document->user_id,
            'user_name' => $document->user?->name,
            'issue_date' => $document->issue_date?->format('Y-m-d'),
            'subject' => $document->subject,
            'sender' => $document->sender,
            'body' => $document->body,
            'requester' => $document->requester,
            'priority' => $document->priority,
            'type' => $document->type,
            'status' => $document->status,
            'validations_count' => $document->validations_count,
            'assigned_to' => $document->assigned_to,
            'assigned_user_name' => $document->assignedUser?->name,
            'assignment_message' => $document->assignment_message,
            'signature_s3_url' => $document->signature_s3_url,
            'stamp_s3_url' => $document->stamp_s3_url,
        ];
    }

    /**
     * Comparar dos versiones y obtener las diferencias
     *
     * @param BackofficeDocumentVersion $version
     * @return array
     */
    public function compareVersions(BackofficeDocumentVersion $version): array
    {
        // Obtener la versión anterior
        $previousVersion = BackofficeDocumentVersion::where('document_id', $version->document_id)
            ->where('id', '<', $version->id)
            ->orderBy('id', 'desc')
            ->first();
        
        if (!$previousVersion) {
            return []; // Es la primera versión
        }
        
        return $this->getDifferences($previousVersion->snapshot ?? [], $version->snapshot ?? []);
    }

    /**
     * Obtener las diferencias entre dos snapshots
     *
     * @param array $previous
     * @param array $current
     * @return array
     */
    protected function getDifferences(array $previous, array $current): array
    {
        $differences = [];
        
        // Campos a comparar con sus etiquetas
        $fieldsToCompare = [
            'subject' => 'Asunto',
            'sender' => 'Remitente',
            'body' => 'Cuerpo del Oficio',
            'requester' => 'Solicitante',
            'priority' => 'Prioridad',
            'type' => 'Tipo',
            'status' => 'Estado',
            'assigned_user_name' => 'Asignado a',
            'assignment_message' => 'Mensaje de Asignación',
            'validations_count' => 'Validaciones',
        ];
        
        foreach ($fieldsToCompare as $field => $label) {
            $previousValue = $previous[$field] ?? null;
            $currentValue = $current[$field] ?? null;
            
            if ($previousValue !== $currentValue) {
                $differences[$field] = [
                    'label' => $label,
                    'field' => $field,
                    'previous' => $previousValue,
                    'current' => $currentValue,
                ];
            }
        }
        
        return $differences;
    }

    /**
     * Reconstruir el estado del documento en una versión específica
     *
     * @param BackofficeDocumentVersion $version
     * @return array
     */
    public function getDocumentAtVersion(BackofficeDocumentVersion $version): array
    {
        return $version->snapshot ?? [];
    }

    /**
     * Obtener el historial completo de versiones de un documento
     *
     * @param BackofficeDocument $document
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVersionHistory(BackofficeDocument $document)
    {
        return $document->versions()
            ->with('modifiedByUser')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtener los campos modificados en una versión específica
     *
     * @param BackofficeDocumentVersion $version
     * @return array Lista de campos que cambiaron
     */
    public function getModifiedFields(BackofficeDocumentVersion $version): array
    {
        $differences = $this->compareVersions($version);
        return array_keys($differences);
    }
}

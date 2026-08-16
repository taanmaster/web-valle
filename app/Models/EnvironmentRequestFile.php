<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EnvironmentRequestFile extends Model
{
    use HasFactory;

    /**
     * Documentos obligatorios que adjunta el ciudadano en Donación.
     */
    public const DOC_INE = 'ine';

    public const DOC_CARTA_COMPROMISO = 'carta_compromiso';

    public const DOC_SOLICITUD_DONACION = 'solicitud_donacion';

    /**
     * Evidencia fotográfica que sube la Dirección en Poda y Tala.
     */
    public const DOC_EVIDENCIA = 'evidencia';

    public const DONACION_DOCUMENTS = [
        self::DOC_INE => 'Identificación oficial (INE)',
        self::DOC_CARTA_COMPROMISO => 'Carta compromiso del ciudadano',
        self::DOC_SOLICITUD_DONACION => 'Solicitud de donación',
    ];

    protected $fillable = [
        'user_id',
        'environment_request_id',
        'document_type',
        'name',
        'slug',
        'filename',
        'file_extension',
        'filesize',
        's3_asset_url',
    ];

    public function environmentRequest()
    {
        return $this->belongsTo(EnvironmentRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tamaño del archivo en formato legible.
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->filesize;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        } elseif ($bytes > 1) {
            return $bytes.' bytes';
        } elseif ($bytes == 1) {
            return $bytes.' byte';
        }

        return '0 bytes';
    }

    public function getUrlAttribute()
    {
        return $this->s3_asset_url ?: Storage::disk('s3')->url('medio_ambiente/'.$this->filename);
    }

    public function getDocumentTypeLabelAttribute(): string
    {
        return self::DONACION_DOCUMENTS[$this->document_type]
            ?? ($this->document_type === self::DOC_EVIDENCIA ? 'Evidencia fotográfica' : $this->document_type);
    }
}

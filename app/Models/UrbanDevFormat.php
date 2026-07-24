<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UrbanDevFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'urban_dev_request_id',
        'format_type',
        'data',
        'croquis_path',
        'signature_applicant_path',
        'signature_perito_path',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Solicitud a la que pertenece el formato.
     */
    public function request()
    {
        return $this->belongsTo(\App\Models\UrbanDevRequest::class, 'urban_dev_request_id');
    }

    /**
     * URL pública (S3) del croquis, si existe.
     */
    public function getCroquisUrlAttribute(): ?string
    {
        return $this->croquis_path ? Storage::disk('s3')->url($this->croquis_path) : null;
    }

    /**
     * URL pública (S3) de la firma del solicitante, si existe.
     */
    public function getSignatureApplicantUrlAttribute(): ?string
    {
        return $this->signature_applicant_path ? Storage::disk('s3')->url($this->signature_applicant_path) : null;
    }

    /**
     * URL pública (S3) de la firma del perito, si existe.
     */
    public function getSignaturePeritoUrlAttribute(): ?string
    {
        return $this->signature_perito_path ? Storage::disk('s3')->url($this->signature_perito_path) : null;
    }
}

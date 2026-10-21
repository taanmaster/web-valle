<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilProtectionCaseDocumentVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'civil_protection_case_document_id',
        'version',
        'filename',
        'filesize',
        's3_url',
        'uploaded_by',
        'uploaded_by_citizen',
    ];

    protected $casts = [
        'uploaded_by_citizen' => 'boolean',
    ];

    public function document()
    {
        return $this->belongsTo(CivilProtectionCaseDocument::class, 'civil_protection_case_document_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUploaderLabelAttribute()
    {
        return $this->uploaded_by_citizen ? 'Ciudadano' : ($this->uploader->name ?? 'Sistema');
    }

    public function getSizeLabelAttribute()
    {
        $kb = ($this->filesize ?? 0) / 1024;

        return $kb >= 1024 ? number_format($kb / 1024, 1).' MB' : round($kb).' KB';
    }
}

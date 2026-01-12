<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackofficeDocumentValidation extends Model
{
    use HasFactory;

    protected $table = 'backoffice_document_validations';

    protected $fillable = [
        'document_id',
        'validator_id',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: Validación pertenece a un documento
     */
    public function document()
    {
        return $this->belongsTo(BackofficeDocument::class, 'document_id');
    }

    /**
     * Relación: Validación hecha por un usuario
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}

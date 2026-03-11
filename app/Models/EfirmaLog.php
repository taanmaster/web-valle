<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EfirmaLog extends Model
{
    use HasFactory;

    protected $table = 'efirma_logs';

    protected $fillable = [
        'document_id',
        'event',
        'payload',
        'response',
        'http_status',
        'success',
    ];

    protected $casts = [
        'payload'     => 'array',
        'response'    => 'array',
        'http_status' => 'integer',
        'success'     => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    /**
     * Relación: Log pertenece a un documento
     */
    public function document()
    {
        return $this->belongsTo(BackofficeDocument::class, 'document_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCertificatePayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function certificate()
    {
        return $this->belongsTo(DocumentCertificate::class, 'document_certificate_id');
    }
}

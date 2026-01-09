<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentificationCertificatePayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function certificate()
    {
        return $this->belongsTo(IdentificationCertificate::class, 'certificate_id');
    }
}

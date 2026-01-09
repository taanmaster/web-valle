<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentificationCertificate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment()
    {
        return $this->hasOne(IdentificationCertificatePayment::class, 'certificate_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestRequirement extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'presentation' => 'array',
        'third_party_issued' => 'boolean',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }
}

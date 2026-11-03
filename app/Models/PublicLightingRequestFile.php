<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicLightingRequestFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_lighting_request_id',
        'user_id',
        'type',
        'name',
        'filename',
        'file_extension',
        'filesize',
        's3_asset_url',
    ];

    public function lightingRequest()
    {
        return $this->belongsTo(PublicLightingRequest::class, 'public_lighting_request_id');
    }
}

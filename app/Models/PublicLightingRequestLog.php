<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicLightingRequestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_lighting_request_id',
        'user_id',
        'status',
        'message',
    ];

    public function lightingRequest()
    {
        return $this->belongsTo(PublicLightingRequest::class, 'public_lighting_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getStatusLabelAttribute()
    {
        return PublicLightingRequest::STATUSES[$this->status][0] ?? $this->status;
    }
}

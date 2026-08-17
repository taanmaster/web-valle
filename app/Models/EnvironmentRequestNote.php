<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvironmentRequestNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'environment_request_id',
        'user_id',
        'note',
    ];

    public function environmentRequest()
    {
        return $this->belongsTo(EnvironmentRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

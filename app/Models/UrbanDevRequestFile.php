<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrbanDevRequestFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'urban_dev_request_id',
        'name',
        'slug',
        'filename',
        'file_extension',
    ];

    /**
     * Relación con la solicitud de desarrollo urbano
     */
    public function urbanDevRequest()
    {
        return $this->belongsTo(\App\Models\UrbanDevRequest::class);
    }

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

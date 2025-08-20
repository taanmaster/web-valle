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
        'filesize',
        's3_asset_url',
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

    /**
     * Obtener el tamaño del archivo en formato legible
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->filesize;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    /**
     * Obtener la URL del archivo
     */
    public function getUrlAttribute()
    {
        return $this->s3_asset_url ?: \Storage::disk('s3')->url('desarrollo_urbano/' . $this->filename);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SareRequestFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sare_request_id',
        'name',
        'slug',
        'filename',
        'file_extension',
        'file_name',
        'file_size',
        'file_type',
        's3_asset_url'
    ];

    /**
     * Relación con la solicitud SARE
     */
    public function sareRequest()
    {
        return $this->belongsTo(SareRequest::class);
    }

    /**
     * Relación con el usuario que subió el archivo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Obtener el tamaño del archivo en formato legible
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        
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
        return $this->s3_asset_url ?: \Storage::disk('s3')->url('sare/' . $this->filename);
    }
}

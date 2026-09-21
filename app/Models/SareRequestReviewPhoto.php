<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SareRequestReviewPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'sare_request_review_id',
        'filename',
        'filesize',
        's3_asset_url',
    ];

    /**
     * Relación con la revisión a la que pertenece la fotografía
     */
    public function review()
    {
        return $this->belongsTo(SareRequestReview::class, 'sare_request_review_id');
    }

    /**
     * Obtener la URL de la fotografía
     */
    public function getUrlAttribute()
    {
        return $this->s3_asset_url;
    }
}

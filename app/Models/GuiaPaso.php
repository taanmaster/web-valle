<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuiaPaso extends Model
{
    protected $table = 'guia_pasos';

    protected $fillable = [
        'guia_id',
        'titulo',
        'descripcion',
        'imagen_apoyo',
        'enlace_texto',
        'enlace_url',
        'pregunta_frecuente',
        'mensaje_advertencia',
        'archivo_adjunto',
        'orden',
    ];

    public function guia(): BelongsTo
    {
        return $this->belongsTo(Guia::class);
    }

    public function imagenApoyoUrl(): ?string
    {
        return $this->imagen_apoyo
            ? \Storage::disk('s3')->url($this->imagen_apoyo)
            : null;
    }

    public function archivoAdjuntoUrl(): ?string
    {
        return $this->archivo_adjunto
            ? \Storage::disk('s3')->url($this->archivo_adjunto)
            : null;
    }
}

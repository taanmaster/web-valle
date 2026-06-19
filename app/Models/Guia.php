<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guia extends Model
{
    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'imagen_portada',
        'guia_categoria_id',
        'dependencia',
        'mostrar_front',
        'mostrar_admin',
        'destacada',
        'fecha_entrada',
    ];

    protected $casts = [
        'mostrar_front' => 'boolean',
        'mostrar_admin' => 'boolean',
        'destacada'     => 'boolean',
        'fecha_entrada' => 'date',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(GuiaCategoria::class, 'guia_categoria_id');
    }

    public function pasos(): HasMany
    {
        return $this->hasMany(GuiaPaso::class)->orderBy('orden');
    }

    public function cambios(): HasMany
    {
        return $this->hasMany(GuiaCambio::class)->latest();
    }

    public function portadaUrl(): ?string
    {
        return $this->imagen_portada
            ? \Storage::disk('s3')->url($this->imagen_portada)
            : null;
    }
}

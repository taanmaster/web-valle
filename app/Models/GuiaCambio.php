<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuiaCambio extends Model
{
    protected $table = 'guia_cambios';

    protected $fillable = [
        'guia_id',
        'user_id',
        'descripcion',
        'detalle',
    ];

    protected $casts = [
        'detalle' => 'array',
    ];

    public function guia(): BelongsTo
    {
        return $this->belongsTo(Guia::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

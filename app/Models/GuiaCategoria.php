<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuiaCategoria extends Model
{
    protected $table = 'guia_categorias';

    protected $fillable = ['nombre'];

    public function guias(): HasMany
    {
        return $this->hasMany(Guia::class, 'guia_categoria_id');
    }
}

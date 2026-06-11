<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panteon extends Model
{
    protected $table = 'panteones';

    protected $fillable = [
        'entero',
        'folio',
        'fecha',
        'comprobante_pdf',
        'nombre_solicitante',
        'nombre_finado',
        'domicilio',
        'localidad',
        'fundamento_legal',
        'concepto',
        'tipo',
        'zona',
        'observaciones',
        'panteon',
        'seccion',
        'bloque',
        'manzana',
        'terreno',
        'ref_art',
        'ref_frac',
        'ref_inc',
        'ref_num',
        'monto',
        'cantidad_letra',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapSupplierDependency extends Model
{
    use HasFactory;

    protected $table = 'tap_supplier_dependencies';

    protected $fillable = [
        'supplier_id',
        'dependency_id',
    ];

    //Relación con los proveedores
    public function supplier()
    {
        return $this->belongsTo(TreasuryAccountPayableSupplier::class, 'supplier_id');
    }

    //Relación con las dependencias
    public function dependency()
    {
        return $this->belongsTo(TransparencyDependency::class, 'dependency_id');
    }
}

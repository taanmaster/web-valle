<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'message',
        'status',
    ];

    /**
     * Relación con el usuario (proveedor)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con la alta de proveedor
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

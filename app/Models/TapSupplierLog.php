<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapSupplierLog extends Model
{
    use HasFactory;

    protected $table = 'tap_supplier_logs';
    protected $guarded = [
        'status',
        'description',
    ];

    public function supplier()
    {
        return $this->belongsTo(TreasuryAccountPayableSupplier::class, 'supplier_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableSupplier extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_suppliers';
    protected $guarded = [
        'status'
    ];

    public function checklists()
    {
        return $this->hasMany(TreasuryAccountPayableSupplierChecklist::class, 'supplier_id');
    }

    public function autorizations()
    {
        return $this->hasMany(TreasuryAccountPayableSupplierChecklistAutorization::class, 'supplier_id');
    }

    public function logs()
    {
        return $this->hasMany(TapSupplierLog::class, 'supplier_id');
    }

    // Relación many-to-many con programas
    public function dependencies()
    {
        return $this->belongsToMany(TransparencyDependency::class, 'tap_supplier_dependencies', 'supplier_id', 'dependency_id');
    }

    // Relación con la tabla pivot
    public function supplierDependencies()
    {
        return $this->hasMany(TapSupplierDependency::class, 'supplier_id');
    }
}

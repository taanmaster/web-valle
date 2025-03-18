<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableSupplierChecklist extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_supplier_checklists';
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(TreasuryAccountPayableSupplier::class);
    }

    public function autorizations()
    {
        return $this->hasMany(TreasuryAccountPayableSupplierChecklistAutorization::class);
    }
    
}

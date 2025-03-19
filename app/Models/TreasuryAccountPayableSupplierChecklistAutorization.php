<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableSupplierChecklistAutorization extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_supplier_checklist_autorizations';
    protected $guarded = [];

    public function checklist()
    {
        return $this->belongsTo(TreasuryAccountPayableSupplierChecklist::class, 'supplier_checklist_id');
    }

    public function autorizationList()
    {
        return $this->hasMany(TreasuryAccountPayableSupplierChecklistAutorizationList::class, 'autorization_id');
    }
}

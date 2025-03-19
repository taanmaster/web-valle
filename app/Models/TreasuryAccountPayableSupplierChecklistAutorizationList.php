<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableSupplierChecklistAutorizationList extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_supplier_checklist_autorization_list';
    protected $guarded = [];

    public function autorization()
    {
        return $this->belongsTo(TreasuryAccountPayableSupplierChecklistAutorization::class, 'autorization_id');
    }
}

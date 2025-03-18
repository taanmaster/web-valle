<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableSupplier extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_suppliers';
    protected $guarded = [];

    public function checklists()
    {
        return $this->hasMany(TreasuryAccountPayableSupplierChecklist::class);
    }

    public function autorizations()
    {
        return $this->hasMany(TreasuryAccountPayableSupplierChecklistAutorization::class);
    }
}

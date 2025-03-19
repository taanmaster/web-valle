<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableContractor extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_contractors';
    protected $guarded = [];

    public function checklists()
    {
        return $this->hasMany(TreasuryAccountPayableContractorChecklist::class, 'contractor_id');
    }
}

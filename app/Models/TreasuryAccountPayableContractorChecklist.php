<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableContractorChecklist extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_contractor_checklists';
    protected $guarded = [];

    public function contractor()
    {
        return $this->belongsTo(TreasuryAccountPayableContractor::class, 'contractor_id');
    }

    public function checklist()
    {
        return $this->belongsTo(TreasuryAccountPayableChecklist::class, 'checklist_id');
    }
}

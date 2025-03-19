<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableChecklistElement extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_checklist_elements';
    protected $guarded = [];

    public function checklist()
    {
        return $this->belongsTo(TreasuryAccountPayableChecklist::class, 'checklist_id');
    }
}

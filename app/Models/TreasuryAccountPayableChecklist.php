<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryAccountPayableChecklist extends Model
{
    use HasFactory;

    protected $table = 'treasury_account_payable_checklists';
    protected $guarded = [];

    public function elements()
    {
        return $this->hasMany(TreasuryAccountPayableChecklistElement::class);
    }
}

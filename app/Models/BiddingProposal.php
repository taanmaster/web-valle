<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingProposal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id');
    }

    public function award()
    {
        return $this->hasOne(BiddingAward::class, 'proposal_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}

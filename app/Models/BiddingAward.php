<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingAward extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id');
    }

    public function proposal()
    {
        return $this->belongsTo(BiddingProposal::class, 'proposal_id');
    }
}

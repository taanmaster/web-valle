<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function proposals()
    {
        return $this->hasMany(BiddingProposal::class, 'bidding_id');
    }

    public function contracts()
    {
        return $this->hasMany(BiddingContract::class, 'bidding_id');
    }

    public function deliverables()
    {
        return $this->hasMany(BiddingDeliverable::class, 'bidding_id');
    }

    public function files()
    {
        return $this->hasMany(BiddingFile::class, 'bidding_id');
    }

    public function awards()
    {
        return $this->hasOne(BiddingAward::class, 'bidding_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketCollectionNote extends Model
{
    use HasFactory;

    protected $fillable = ['market_stall_id', 'user_id', 'date', 'comment'];

    protected $casts = ['date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

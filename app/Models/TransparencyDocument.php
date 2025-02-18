<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyDocument extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function obligation()
    {
    	return $this->belongsTo(TransparencyObligation::class, 'obligation_id');
    }

    public function uploaded_by()
    {
    	return $this->belongsTo(User::class, 'id','uploaded_by');
    }
}

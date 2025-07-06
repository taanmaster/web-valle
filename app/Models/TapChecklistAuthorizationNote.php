<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapChecklistAuthorizationNote extends Model
{
    use HasFactory;

    protected $table = 'tap_checklist_authorization_notes';
    protected $guarded = [];

    public function authorization()
    {
        return $this->belongsTo(TapChecklistAuthorization::class, 'authorization_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueProfile extends Model
{
    use HasFactory;

    public function provisionalInregers()
    {
        return $this->hasMany(TsrAccountDueProvisionalInteger::class, 'account_due_profile_id');
    }
}

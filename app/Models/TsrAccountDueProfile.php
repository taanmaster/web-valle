<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rfc_curp',
        'type_of_person', // Persona física o moral
        'email',
        'phone',
        'address',
        'zipcode',
        'code',
    ];

    public function integers()
    {
        return $this->hasMany(TsrAccountDueProvisionalInteger::class, 'account_due_profile_id');
    }
}

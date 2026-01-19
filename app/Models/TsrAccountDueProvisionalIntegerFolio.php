<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueProvisionalIntegerFolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'provisional_integer_id',
        'folio',
        'quantity',
    ];

    public function provisionalInteger()
    {
        return $this->belongsTo(TsrAccountDueProvisionalInteger::class, 'provisional_integer_id');
    }
}

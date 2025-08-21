<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFSocioEconomicTestDependent extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_socio_economic_test_dependents';

    protected $fillable = [
        'socio_economic_test_id',
        'name',
        'age',
        'relationship',
        'schooling',
        'marital_status',
        'weekly_income',
        'monthly_income',
        'occupation',
    ];

    /**
     * Relación al test socioeconómico padre
     */
    public function test()
    {
        return $this->belongsTo(DIFSocioEconomicTest::class, 'socio_economic_test_id');
    }
}

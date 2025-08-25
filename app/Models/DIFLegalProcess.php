<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFLegalProcess extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_legal_processes';
    
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'status',
        'case_num',
        'advised_person',
        'advised_street_name',
        'advised_street_num',
        'advised_zip_code',
        'advised_colony',
        'advised_phone',
        'advised_age',
        'advised_ocupation',
        'advised_gender',
        'advised_median_income',
        'advised_children_qty',
        'sued_person',
        'sued_street_name',
        'sued_street_num',
        'sued_zip_code',
        'sued_colony',
        'sued_age',
        'sued_ocupation',
        'sued_gender',
        'sued_median_income',
        'relation_with_advised',
        'reason_for_advisory',
        'observations',
        'cost',
        'socio_economic_test_id'
    ];
}

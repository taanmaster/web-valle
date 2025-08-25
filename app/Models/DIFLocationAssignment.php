<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFLocationAssignment extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_location_assignments';
    
    /**
     * Mass assignable
     */
    protected $fillable = [
        'location_id',
        'model_type',
        'model_id'
    ];

    /**
     * Polymorphic relation to the assigned model (Program or Social Assistance)
     */
    public function model()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'approved_by',
        'filename',
        'filepath',
        'comments',
        'link_approval',
        'link_name',
        'link_approval_signature',
        'director_approval',
        'director_name',
        'director_approval_signature',
    ];

    protected $casts = [
        'link_approval' => 'boolean',
        'director_approval' => 'boolean',
    ];

    /**
     * Relación con el proveedor
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relación con el usuario que aprobó
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyDependency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'image_cover',
        'in_index',
        'belongs_to_treasury',
        'belongs_to',
    ];

    public function users()
    {
        return $this->hasMany(TransparencyDependencyUser::class, 'dependency_id');
    }

    public function documents()
    {
        return $this->hasManyThrough(TransparencyDocument::class, TransparencyObligation::class, 'dependency_id', 'obligation_id');
    }

    public function files()
    {
        return $this->hasMany(TransparencyFile::class, 'dependency_id');
    }

    public function obligations()
    {
        return $this->hasMany(TransparencyObligation::class, 'dependency_id');
    }

    // Relación many-to-many con proveedores
    public function suppliers()
    {
        return $this->belongsToMany(TreasuryAccountPayableSupplier::class, 'tap_supplier_dependencies', 'dependency_id', 'supplier_id');
    }
}

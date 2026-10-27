<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketRate extends Model
{
    use HasFactory;

    public const SPACE_TYPES = [
        'local' => 'Local',
        'lugar' => 'Lugar',
        'plancha' => 'Plancha',
    ];

    protected $fillable = [
        'fiscal_year',
        'space_type',
        'article',
        'subsection',
        'fraction',
        'description',
        'monthly_amount',
        'effective_from',
        'is_active',
    ];

    protected $casts = [
        'monthly_amount' => 'decimal:2',
        'effective_from' => 'date',
        'is_active' => 'boolean',
    ];

    public function stalls()
    {
        return $this->hasMany(MarketStall::class);
    }

    public function getSpaceTypeLabelAttribute()
    {
        return self::SPACE_TYPES[$this->space_type] ?? $this->space_type;
    }

    /**
     * Fundamento como aparece en el padrón: Local · Art. 11 · Inc. A · Frac. II · $520.00
     */
    public function getLegalBasisAttribute()
    {
        return 'Art. '.$this->article.' · Inc. '.$this->subsection.' · Frac. '.$this->fraction;
    }
}

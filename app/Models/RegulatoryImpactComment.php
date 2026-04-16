<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulatoryImpactComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'regulatory_impact_id',
        'user_id',
        'citizen_id',
        'comment_type',
        'content',
    ];

    // ---------- Relaciones ----------

    public function regulatoryImpact()
    {
        return $this->belongsTo(RegulatoryImpact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ---------- Scopes ----------

    public function scopeAdmin($query)
    {
        return $query->where('comment_type', 'admin');
    }

    public function scopePublic($query)
    {
        return $query->where('comment_type', 'public');
    }
}

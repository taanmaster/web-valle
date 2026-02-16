<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TourismThirdPartyRequest extends Model
{
    protected $table = 'tourism_third_party_requests';

    protected $fillable = [
        'folio',
        'user_id',
        'status',
        'full_name',
        'organization_name',
        'applicant_type',
        'rfc_or_curp',
        'fiscal_address',
        'phone',
        'email',
        'event_name',
        'event_type',
        'event_objective',
        'event_description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'venue',
        'event_access_type',
        'expected_impact',
        'estimated_attendees',
        'promotes_identity',
        'generates_economic_impact',
        'support_type',
        'support_description',
        'signature_path',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function observations()
    {
        return $this->hasMany(TourismThirdPartyObservation::class, 'tourism_third_party_request_id');
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'Enviada' => 'primary',
            'En Revisión' => 'warning',
            'Aprobada' => 'success',
            'Rechazada' => 'danger',
            'Cancelada' => 'secondary',
            default => 'info',
        };
    }

    public function getSignatureUrlAttribute()
    {
        if ($this->signature_path) {
            return Storage::disk('s3')->url($this->signature_path);
        }

        return null;
    }

    public static function generateFolio(): string
    {
        $year = date('Y');
        $last = static::where('folio', 'like', "AT{$year}%")
            ->orderBy('folio', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->folio, 6);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'AT' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}

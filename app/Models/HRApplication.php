<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\HRVacancy;
use App\Models\User;

class HRApplication extends Model
{
    protected $table = 'hr_applications';

    protected $fillable = [
        'hr_vacancy_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'cv_path',
        'observations',
    ];

    public function vacancy()
    {
        return $this->belongsTo(HRVacancy::class, 'hr_vacancy_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCvUrlAttribute()
    {
        if ($this->cv_path) {
            return Storage::disk('s3')->url($this->cv_path);
        }

        return null;
    }
}

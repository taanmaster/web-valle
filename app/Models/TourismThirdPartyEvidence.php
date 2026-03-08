<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TourismThirdPartyEvidence extends Model
{
    protected $table = 'tourism_third_party_evidences';

    protected $fillable = [
        'tourism_third_party_request_id',
        'uploaded_by',
        'name',
        'file_path',
        'file_extension',
    ];

    public function request()
    {
        return $this->belongsTo(TourismThirdPartyRequest::class, 'tourism_third_party_request_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileUrlAttribute()
    {
        return Storage::disk('s3')->url($this->file_path);
    }

    public function getFileDownloadUrlAttribute()
    {
        return Storage::disk('s3')->temporaryUrl(
            $this->file_path,
            now()->addMinutes(10),
            ['ResponseContentDisposition' => 'attachment; filename="' . $this->name . '.' . $this->file_extension . '"']
        );
    }
}

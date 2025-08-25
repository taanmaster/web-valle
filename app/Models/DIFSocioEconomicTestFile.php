<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFSocioEconomicTestFile extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_socio_economic_test_files';

    protected $fillable = [
        'user_id',
        'socio_economic_test_id',
        'name',
        'slug',
        'filename',
        'file_extension',
        'file_name',
        'file_size',
        'file_type',
        's3_asset_url'
    ];

    // Relaciones
    public function socioEconomicTest()
    {
        return $this->belongsTo(DIFSocioEconomicTest::class, 'socio_economic_test_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // Accessors
    public function getUrlAttribute()
    {
        return $this->s3_asset_url;
    }

    public function getOriginalNameAttribute()
    {
        return $this->file_name;
    }

    // Métodos de utilidad
    public function getFormattedSizeAttribute()
    {
        if ($this->file_size < 1024) {
            return $this->file_size . ' B';
        } elseif ($this->file_size < 1048576) {
            return round($this->file_size / 1024, 1) . ' KB';
        } else {
            return round($this->file_size / 1048576, 1) . ' MB';
        }
    }

    public function getFileTypeIconAttribute()
    {
        if (str_contains($this->file_type, 'pdf')) {
            return 'fas fa-file-pdf text-danger';
        } elseif (str_contains($this->file_type, 'image')) {
            return 'fas fa-file-image text-success';
        } elseif (str_contains($this->file_type, 'word') || str_contains($this->file_type, 'document')) {
            return 'fas fa-file-word text-primary';
        } else {
            return 'fas fa-file-alt text-secondary';
        }
    }
}

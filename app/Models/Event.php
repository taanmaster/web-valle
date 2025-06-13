<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;
    
    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date_start',
        'date_end',
        'location',
        'blog_url',
        'is_active'
    ];
    
    /**
     * Los atributos que deben convertirse a un tipo nativo.
     *
     * @var array
     */
    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    /**
     * Obtener la fecha de inicio formateada para mostrar.
     *
     * @return string
     */
    public function getFormattedStartDateAttribute()
    {
        return Carbon::parse($this->date_start)->format('d/m/Y H:i');
    }
    
    /**
     * Obtener la fecha de finalización formateada para mostrar.
     *
     * @return string|null
     */
    public function getFormattedEndDateAttribute()
    {
        return $this->date_end ? Carbon::parse($this->date_end)->format('d/m/Y H:i') : null;
    }
    
    /**
     * Verificar si el evento está actualmente en progreso.
     *
     * @return bool
     */
    public function getIsInProgressAttribute()
    {
        $now = Carbon::now();
        return $now->greaterThanOrEqualTo($this->date_start) && 
               (!$this->date_end || $now->lessThanOrEqualTo($this->date_end));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'mail_notifications',
        'sms_notifications',
        'push_notifications',
        'additional_data',
    ];

    protected $casts = [
        'mail_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'additional_data' => 'array',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación polimórfica con el modelo asociado
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Obtener un valor específico del additional_data
     */
    public function getAdditionalDataValue(string $key, $default = null)
    {
        return data_get($this->additional_data, $key, $default);
    }

    /**
     * Verificar si es un proveedor
     */
    public function isSupplier(): bool
    {
        return $this->model_type === 'App\Models\Supplier';
    }

    /**
     * Verificar si es un ciudadano
     */
    public function isCitizen(): bool
    {
        return $this->model_type === 'App\Models\Citizen';
    }
}

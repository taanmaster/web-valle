<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'backoffice_dependency_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function dependency()
    {
        return $this->belongsToMany(TransparencyDependency::class, 'transparency_dependency_users', 'user_id', 'dependency_id')->withPivot('id');
    }

    public function logs()
    {
        return $this->hasMany(MunicipalRegulationLog::class, 'user_id');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'user_id');
    }

    public function endorsements()
    {
        return $this->hasMany(SupplierEndorsement::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(SupplierMessage::class, 'user_id');
    }

    /**
     * Relación: Usuario pertenece a una dependencia de backoffice
     */
    public function backofficeDependency()
    {
        return $this->belongsTo(BackofficeDependency::class, 'backoffice_dependency_id');
    }

    public function hrApplications()
    {
        return $this->hasMany(HRApplication::class, 'user_id');
    }
}

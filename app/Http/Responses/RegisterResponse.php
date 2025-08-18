<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();
        
        // Los ciudadanos van a su perfil después del registro
        if ($user->hasRole('citizen')) {
            return redirect()->route('citizen.profile.index');
        }
        
        // Los admins van al dashboard
        if ($user->hasRole('admin') || $user->can('admin_access')) {
            return redirect()->route('dashboard');
        }
        
        // Por defecto, ir al inicio
        return redirect()->route('index');
    }
}

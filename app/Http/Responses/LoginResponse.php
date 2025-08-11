<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();
        
        // Redireccionar según el rol del usuario
        if ($user->hasRole('admin') || $user->can('admin_access')) {
            return redirect()->intended(route('dashboard'));
        }
        
        if ($user->hasRole('citizen')) {
            return redirect()->intended(route('citizen.profile.index'));
        }
        
        // Por defecto, ir al inicio
        return redirect()->intended(route('index'));
    }
}

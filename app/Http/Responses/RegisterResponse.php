<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();

        // Los ciudadanos van a su perfil después del registro
        // Si hay una URL intended (ej: vacante de RRHH), redirigir allí
        if ($user->hasRole('citizen')) {
            return redirect()->intended(route('citizen.profile.index'));
        }

        // Los admins van al dashboard
        if ($user->hasRole('admin') || $user->can('admin_access')) {
            return redirect()->intended(route('dashboard'));
        }

        // Por defecto, ir al inicio
        return redirect()->intended(route('index'));
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAfterLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Si es administrador, ir al dashboard
            if ($user->hasRole('admin') || $user->can('admin_access')) {
                return redirect()->route('dashboard');
            }
            
            // Si es ciudadano, ir al perfil
            if ($user->hasRole('citizen')) {
                return redirect()->route('citizen.profile.index');
            }
            
            // Por defecto, ir al inicio
            return redirect()->route('index');
        }

        return $next($request);
    }
}

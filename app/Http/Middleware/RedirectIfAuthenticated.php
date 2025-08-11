<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Redireccionar según el rol del usuario
                if ($user->hasRole('admin') || $user->can('admin_access')) {
                    return redirect()->route('dashboard');
                }
                
                if ($user->hasRole('citizen')) {
                    return redirect()->route('citizen.profile.index');
                }
                
                return redirect()->route('index');
            }
        }

        return $next($request);
    }
}

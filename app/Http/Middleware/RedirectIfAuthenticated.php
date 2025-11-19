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
                // Si es empleado autenticado → redirige a /dashboard
                if ($guard === 'employee' || Auth::guard('employee')->check()) {
                    return redirect(route('dashboard'));
                }
                
                // Si es cliente autenticado → redirige a /cliente/dashboard
                if ($guard === 'cliente' || Auth::guard('cliente')->check()) {
                    return redirect(route('cliente.dashboard'));
                }

                // Default
                return redirect(route('dashboard'));
            }
        }

        return $next($request);
    }
}
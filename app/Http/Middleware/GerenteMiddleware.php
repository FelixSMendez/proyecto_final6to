<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GerenteMiddleware
{
    public function handle(Request $request, Closure $next, $roleType = null)
    {
        $empleado = auth('employee')->user();

        // DEBUG - Ver qué está pasando
        \Log::info('Middleware Check:', [
            'user_id' => $empleado ? $empleado->id : 'NULL',
            'role_type' => $empleado && $empleado->rol ? $empleado->rol->tipo : 'NULL',
            'path' => $request->path(),
        ]);

        if ($empleado && $empleado->rol && $empleado->rol->tipo === 'gerente') {
            return $next($request);
        }

        \Log::warning('Middleware DENIED - Redirecting to dashboard');
        return redirect()->route('dashboard')->with('error', 'No autorizado');
    }
}


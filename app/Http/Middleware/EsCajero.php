<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EsCajero
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('employee')->check() && auth('employee')->user()->rol === 'cajero') {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Solo cajeros pueden acceder a esta sección');
    }
}

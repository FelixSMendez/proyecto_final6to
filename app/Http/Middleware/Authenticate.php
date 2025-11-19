<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Si intenta /dashboard sin login → redirige a /login
            if ($request->is('dashboard*')) {
                return route('login');
            }
            
            // Si intenta /cliente/* sin login → redirige a /cliente/login
            if ($request->is('cliente/*')) {
                return route('cliente.login');
            }
        }

        return null;
    }
}
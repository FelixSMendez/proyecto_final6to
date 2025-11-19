<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClienteLoginController extends Controller
{
    public function create()
    {
        return view('auth.cliente-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'usuario' => 'required|string',
            'contrasena' => 'required|string',
        ]);

        $credentials['password'] = $credentials['contrasena'];
        unset($credentials['contrasena']);

        if (!Auth::guard('cliente')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'usuario' => ['Usuario o contraseña incorrectos'],
            ]);
        }

        $request->session()->regenerate();
        return redirect()->route('cliente.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('cliente')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

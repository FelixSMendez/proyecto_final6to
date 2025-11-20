<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * ✅ PARA EMPLEADOS USANDO GUARD 'employee'
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar credenciales
        $credentials = $request->validate([
            'usuario' => ['required', 'string'],
            'contrasena' => ['required', 'string'],
        ], [
            'usuario.required' => 'El usuario es requerido',
            'contrasena.required' => 'La contraseña es requerida',
        ]);

        // Intentar autenticar con guard 'employee'
        // Nota: mapear 'contrasena' a 'password' que Laravel espera
        if (Auth::guard('employee')->attempt(
            ['usuario' => $request->usuario, 'password' => $request->contrasena], // el array se llama password/contrasena
            $request->boolean('remember')
        )) {
            // ✅ Autenticación exitosa
            $request->session()->regenerate();
            $user = Auth::guard('employee')->user();

            // Redireccionar según el rol del usuario
            switch ($user->tipoRol ?? 'digitador') {
                case 'digitador':
                    return redirect()->route('dashboard.digitador');
                case 'cajero':
                    return redirect()->route('dashboard.cajero');
                case 'gerente':
                    return redirect()->route('gerente.dashboard');
                default:
                    return redirect()->route('dashboard');
            }
        }

        // ❌ Credenciales inválidas
        return back()->withErrors([
            'usuario' => 'Usuario o contraseña incorrectos',
        ])->onlyInput('usuario');
    }

    /**
     * Destroy an authenticated session.
     * ✅ LOGOUT PARA EMPLEADOS
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout del guard 'employee'
        Auth::guard('employee')->logout();

        // Invalidar sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;

class UsuarioSistemaController extends Controller
{
    public function index()
    {
        $usuarios = User::paginate(15);
        return view('usuariosistema.index', compact('usuarios'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('usuariosistema.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:50|unique:usuariosistema,usuario',
            'contrasena' => 'required|string|max:200',
            'id_empleado' => 'nullable|exists:empleado,id',
        ]);

        User::create($request->all());
        return redirect()->route('usuariosistema.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuariosistema)
    {
        $empleados = Empleado::all();
        return view('usuariosistema.edit', compact('usuariosistema', 'empleados'));
    }

    public function update(Request $request, User $usuariosistema)
    {
        $request->validate([
            'usuario' => 'required|string|max:50|unique:usuariosistema,usuario,' . $usuariosistema->id,
            'contrasena' => 'nullable|string|max:200', // ✅ OPCIONAL en actualización
            'id_empleado' => 'nullable|exists:empleado,id',
        ]);

        $data = $request->all();
        
        
        if (empty($data['contrasena'])) {
            unset($data['contrasena']);
        }
        $usuariosistema->update($data);
        return redirect()->route('usuariosistema.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuariosistema)
    {
        $usuariosistema->delete();
        return redirect()->route('usuariosistema.index')->with('success', 'Usuario eliminado correctamente.');
    }
}

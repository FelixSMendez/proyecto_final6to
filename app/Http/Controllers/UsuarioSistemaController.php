<?php

namespace App\Http\Controllers;

use App\Models\UsuarioSistema;
use App\Models\Empleado;
use App\Models\Cliente;
use Illuminate\Http\Request;

class UsuarioSistemaController extends Controller
{
    public function index()
    {
        $usuarios = UsuarioSistema::all();
        return view('usuariosistema.index', compact('usuarios'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        $clientes = Cliente::all();
        return view('usuariosistema.create', compact('empleados', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:50',
            'contrasena' => 'required|string|max:200',
            'id_empleado' => 'nullable|exists:empleado,id',
            'id_cliente' => 'nullable|exists:cliente,id',
        ]);

        UsuarioSistema::create($request->all());
        return redirect()->route('usuariosistema.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(UsuarioSistema $usuariosistema)
    {
        $empleados = Empleado::all();
        $clientes = Cliente::all();
        return view('usuariosistema.edit', compact('usuariosistema', 'empleados', 'clientes'));
    }

    public function update(Request $request, UsuarioSistema $usuariosistema)
    {
        $request->validate([
            'usuario' => 'required|string|max:50',
            'contrasena' => 'required|string|max:200',
            'id_empleado' => 'nullable|exists:empleado,id',
            'id_cliente' => 'nullable|exists:cliente,id',
        ]);

        $usuariosistema->update($request->all());
        return redirect()->route('usuariosistema.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(UsuarioSistema $usuariosistema)
    {
        $usuariosistema->delete();
        return redirect()->route('usuariosistema.index')->with('success', 'Usuario eliminado correctamente.');
    }
}

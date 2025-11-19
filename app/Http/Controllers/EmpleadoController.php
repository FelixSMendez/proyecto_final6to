<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Rol;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('rol')->get();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('empleados.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'id_rol' => 'nullable|exists:rol,id',
        ]);

        Empleado::create($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');
    }

    public function edit(Empleado $empleado)
    {
        $roles = Rol::all();
        return view('empleados.edit', compact('empleado', 'roles'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'id_rol' => 'nullable|exists:rol,id',
        ]);

        $empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}

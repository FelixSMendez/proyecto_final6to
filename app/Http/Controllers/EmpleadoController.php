<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Rol;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with(['rol', 'sucursal'])->paginate(15);
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $roles = Rol::all();
        $sucursales = Sucursal::all();
        return view('empleados.create', compact('roles', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:empleado,email',
            'id_rol' => 'required|exists:rol,id',
            'id_sucursal' => 'required|exists:sucursal,id',
        ]);

        Empleado::create($request->all());
        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');
    }

    public function edit(Empleado $empleado)
    {
        $roles = Rol::all();
        $sucursales = Sucursal::all();
        return view('empleados.edit', compact('empleado', 'roles', 'sucursales'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:empleado,email,' . $empleado->id,
            'id_rol' => 'required|exists:rol,id',
            'id_sucursal' => 'required|exists:sucursal,id',
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
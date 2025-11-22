<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\UsuarioCliente;

class UsuarioClienteController extends Controller
{
    public function index()
    {
        $usuariosc = UsuarioCliente::paginate(15);
        return view('usuariocliente.index', compact('usuariosc'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('usuariocliente.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:50',
            'contrasena' => 'nullable|string|max:200',
            'correo_electronico' => 'nullable|string|max:100',
            'id_cliente' => 'required|exists:cliente,id',
        ]);

        UsuarioCliente::create($request->all());
        return redirect()->route('usuariocliente.index')->with('success', 'Usuario de cliente creado exitosamente');
    }

    public function edit(UsuarioCliente $usuariocliente)
    {
        $clientes = Cliente::all();
        return view('usuariocliente.edit', compact('usuariocliente', 'clientes'));
    }

    public function update(Request $request, UsuarioCliente $usuariocliente)
    {
        $request->validate([
            'usuario' => 'required|string|max:50',
            'contrasena' => 'nullable|string|max:200',
            'correo_electronico' => 'nullable|string|max:100',
            'id_cliente' => 'required|exists:cliente,id',
        ]);

        $usuariocliente->update($request->all());
        return redirect()->route('usuariocliente.index')->with('success', 'El usuario del cliente fue actualizado correctamente.');
    }

    public function destroy(UsuarioCliente $usuariocliente)
    {
        $usuariocliente->delete();
        return redirect()->route('usuariocliente.index')->with('success', 'El usuario del cliente eliminado correctamente.');
    }

}

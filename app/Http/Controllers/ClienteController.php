<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::paginate(15);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:20',
            'tipo'      => 'required|in:mayorista,minorista',
            'latitud'  => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            
        ]);

        Cliente::create([
            'nombre'    => $request->nombre,
            'email'     => $request->email,
            'dirección' => $request->dirección,
            'teléfono'  => $request->teléfono,
            'tipo'      => $request->tipo,
            'latitud'   => $request->latitud,
            'longitud'  => $request->longitud,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'email'     => 'nullable|email|max:100',
            'dirección' => 'nullable|string|max:150',
            'teléfono'  => 'nullable|string|max:20',
            'tipo'      => 'required|in:mayorista,minorista',
            'latitud'   => 'nullable|numeric',
            'longitud'  => 'nullable|numeric',
        ]);

         $cliente->update([
            'nombre'    => $request->nombre,
            'email'     => $request->email,
            'dirección' => $request->dirección,
            'teléfono'  => $request->teléfono,
            'tipo'      => $request->tipo,
            'latitud'   => $request->latitud,
            'longitud'  => $request->longitud,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Cliente;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carritos = Carrito::all();
        return view('carritos.index', compact('carritos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('carritos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'nullable|exists:cliente,id',
            'fecha_creacion' => 'nullable|date',
        ]);

        Carrito::create($request->all());
        return redirect()->route('carritos.index')->with('success', 'Carrito creado correctamente.');
    }

    public function edit(Carrito $carrito)
    {
        $clientes = Cliente::all();
        return view('carritos.edit', compact('carrito', 'clientes'));
    }

    public function update(Request $request, Carrito $carrito)
    {
        $request->validate([
            'id_cliente' => 'nullable|exists:cliente,id',
            'fecha_creacion' => 'nullable|date',
        ]);

        $carrito->update($request->all());
        return redirect()->route('carritos.index')->with('success', 'Carrito actualizado correctamente.');
    }

    public function destroy(Carrito $carrito)
    {
        $carrito->delete();
        return redirect()->route('carritos.index')->with('success', 'Carrito eliminado correctamente.');
    }
}

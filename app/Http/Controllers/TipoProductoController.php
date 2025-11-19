<?php

namespace App\Http\Controllers;

use App\Models\TipoProducto;
use Illuminate\Http\Request;

class TipoProductoController extends Controller
{
    public function index()
    {
        $tipos = TipoProducto::all();
        return view('tiposproductos.index', compact('tipos'));
    }

    public function create()
    {
        return view('tiposproductos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:200',
        ]);

        TipoProducto::create($request->all());
        return redirect()->route('tiposproductos.index')->with('success', 'Tipo de producto creado correctamente.');
    }

    public function edit(TipoProducto $tiposproducto)
    {
        return view('tiposproductos.edit', compact('tiposproducto'));
    }

    public function update(Request $request, TipoProducto $tiposproducto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:200',
        ]);

        $tiposproducto->update($request->all());
        return redirect()->route('tiposproductos.index')->with('success', 'Tipo de producto actualizado correctamente.');
    }

    public function destroy(TipoProducto $tiposproducto)
    {
        $tiposproducto->delete();
        return redirect()->route('tiposproductos.index')->with('success', 'Tipo de producto eliminado correctamente.');
    }
}

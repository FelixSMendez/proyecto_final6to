<?php

namespace App\Http\Controllers;

use App\Models\DetalleProducto;
use App\Models\TipoMedida;
use Illuminate\Http\Request;

class DetalleProductoController extends Controller
{
    public function index()
    {
        $detalles = DetalleProducto::with('tipoMedida')->get();
        return view('detalleproductos.index', compact('detalles'));
    }

    public function create()
    {
        $tiposMedida = TipoMedida::all();
        return view('detalleproductos.create', compact('tiposMedida'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tipoMedida' => 'required|exists:tipomedida,id',
            'color' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string|max:200',
        ]);

        DetalleProducto::create($request->all());
        return redirect()->route('detalleproductos.index')->with('success', 'Detalle de producto creado correctamente.');
    }

    public function edit(DetalleProducto $detalleproducto)
    {
        $tiposMedida = TipoMedida::all();
        return view('detalleproductos.edit', compact('detalleproducto', 'tiposMedida'));
    }

    public function update(Request $request, DetalleProducto $detalleproducto)
    {
        $request->validate([
            'id_tipoMedida' => 'required|exists:tipomedida,id',
            'color' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string|max:200',
        ]);

        $detalleproducto->update($request->all());
        return redirect()->route('detalleproductos.index')->with('success', 'Detalle de producto actualizado correctamente.');
    }

    public function destroy(DetalleProducto $detalleproducto)
    {
        $detalleproducto->delete();
        return redirect()->route('detalleproductos.index')->with('success', 'Detalle de producto eliminado correctamente.');
    }
}

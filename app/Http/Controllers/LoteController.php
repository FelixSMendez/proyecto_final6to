<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Producto;
use App\Models\Marca;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index()
    {
        $lotes = Lote::with('producto', 'marca')->get();
        return view('lotes.index', compact('lotes'));
    }

    public function create()
    {
        $productos = Producto::all();
        $marcas = Marca::all();
        return view('lotes.create', compact('productos', 'marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'costoUnidad' => 'required|numeric',
            'fechaCaducidad' => 'required|date',
            'fechaEntrada' => 'required|date',
            'codLote' => 'required|string|max:50',
        ]);

        Lote::create($request->all());
        return redirect()->route('lotes.index')->with('success', 'Lote creado correctamente.');
    }

    public function edit(Lote $lote)
    {
        $productos = Producto::all();
        $marcas = Marca::all();
        return view('lotes.edit', compact('lote', 'productos', 'marcas'));
    }

    public function update(Request $request, Lote $lote)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'costoUnidad' => 'required|numeric',
            'fechaCaducidad' => 'required|date',
            'fechaEntrada' => 'required|date',
            'codLote' => 'required|string|max:50',
        ]);

        $lote->update($request->all());
        return redirect()->route('lotes.index')->with('success', 'Lote actualizado correctamente.');
    }

    public function destroy(Lote $lote)
    {
        $lote->delete();
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Lote;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('lote', 'sucursal')->get();
        return view('inventario.index', compact('inventarios'));
    }

    public function create()
    {
        $lotes = Lote::all();
        $sucursales = Sucursal::all();
        return view('inventario.create', compact('lotes', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'existencia' => 'required|integer',
            'id_lote' => 'required|exists:lote,id',
            'id_sucursal' => 'required|exists:sucursal,id',
        ]);

        Inventario::create($request->all());
        return redirect()->route('inventario.index')->with('success', 'Inventario creado correctamente.');
    }

    public function edit(Inventario $inventario)
    {
        $lotes = Lote::all();
        $sucursales = Sucursal::all();
        return view('inventario.edit', compact('inventario', 'lotes', 'sucursales'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $request->validate([
            'existencia' => 'required|integer',
            'id_lote' => 'required|exists:lote,id',
            'id_sucursal' => 'required|exists:sucursal,id',
        ]);

        $inventario->update($request->all());
        return redirect()->route('inventario.index')->with('success', 'Inventario actualizado correctamente.');
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')->with('success', 'Inventario eliminado correctamente.');
    }
}

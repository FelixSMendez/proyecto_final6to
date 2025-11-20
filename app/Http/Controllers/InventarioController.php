<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\DetalleProducto;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    // ✅ Listar inventario
    public function index()
    {
        $inventarios = Inventario::with('detalleProducto.producto', 'sucursal')
            ->paginate(15);

        return view('inventario.index', compact('inventarios'));
    }

    // ✅ Crear formulario
    public function create()
    {
        $detallesProducto = DetalleProducto::with('producto')->get();
        $sucursales = Sucursal::all();

        return view('inventario.create', compact('detallesProducto', 'sucursales'));
    }

    // ✅ Guardar inventario
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_detalleproducto' => 'required|exists:detalleproducto,id',
            'id_sucursal' => 'required|exists:sucursal,id',
            'stock_minimo' => 'required|integer|min:1',
            'stock_maximo' => 'required|integer|min:1',
            'stock_actual' => 'required|integer|min:0',
        ]);

        $validated['existencia'] = $validated['stock_actual'];

        Inventario::create($validated);

        return redirect()->route('inventario.index')
            ->with('success', 'Inventario creado correctamente');
    }

    // ✅ Editar
    public function edit(Inventario $inventario)
    {
        $detallesProducto = DetalleProducto::with('producto')->get();
        $sucursales = Sucursal::all();

        return view('inventario.edit', compact('inventario', 'detallesProducto', 'sucursales'));
    }

    // ✅ Actualizar
    public function update(Request $request, Inventario $inventario)
    {
        $validated = $request->validate([
            'id_detalleproducto' => 'required|exists:detalleproducto,id',
            'id_sucursal' => 'required|exists:sucursal,id',
            'stock_minimo' => 'required|integer|min:1',
            'stock_maximo' => 'required|integer|min:1',
            'stock_actual' => 'required|integer|min:0',
        ]);

        $validated['existencia'] = $validated['stock_actual'];

        $inventario->update($validated);

        return redirect()->route('inventario.index')
            ->with('success', 'Inventario actualizado correctamente');
    }

    // ✅ Eliminar
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();

        return redirect()->route('inventario.index')
            ->with('success', 'Inventario eliminado correctamente');
    }

    // ✅ Ver detalle
    public function show(Inventario $inventario)
    {
        $inventario->load('detalleProducto.producto', 'sucursal');

        return view('inventario.show', compact('inventario'));
    }

    // ✅ Alertas de bajo stock
    public function alertasStock()
    {
        $alertas = Inventario::whereRaw('stock_actual <= stock_minimo')
            ->with('detalleProducto.producto', 'sucursal')
            ->get();

        return view('inventario.alertas', compact('alertas'));
    }
}

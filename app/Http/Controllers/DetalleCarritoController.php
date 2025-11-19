<?php

namespace App\Http\Controllers;

use App\Models\DetalleCarrito;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;

class DetalleCarritoController extends Controller
{
    public function index()
    {
        $detalles = DetalleCarrito::all();
        return view('detallecarritos.index', compact('detalles'));
    }

    public function create()
    {
        $carritos = Carrito::all();
        $productos = Producto::all();
        return view('detallecarritos.create', compact('carritos', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_carrito' => 'required|exists:carrito,id',
            'id_producto' => 'required|exists:producto,id',
            'cantidad' => 'nullable|integer|min:1',
        ]);

        DetalleCarrito::create($request->all());
        return redirect()->route('detallecarritos.index')->with('success', 'Detalle de carrito creado correctamente.');
    }

    public function edit(DetalleCarrito $detallecarrito)
    {
        $carritos = Carrito::all();
        $productos = Producto::all();
        return view('detallecarritos.edit', compact('detallecarrito', 'carritos', 'productos'));
    }

    public function update(Request $request, DetalleCarrito $detallecarrito)
    {
        $request->validate([
            'id_carrito' => 'required|exists:carrito,id',
            'id_producto' => 'required|exists:producto,id',
            'cantidad' => 'nullable|integer|min:1',
        ]);

        $detallecarrito->update($request->all());
        return redirect()->route('detallecarritos.index')->with('success', 'Detalle de carrito actualizado correctamente.');
    }

    public function destroy(DetalleCarrito $detallecarrito)
    {
        $detallecarrito->delete();
        return redirect()->route('detallecarritos.index')->with('success', 'Detalle de carrito eliminado correctamente.');
    }
}

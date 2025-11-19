<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\TipoProducto;
use App\Models\Proveedor;
use App\Models\DetalleProducto;
use App\Models\Precio;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['tipoProducto','proveedor','detalleProducto','precio'])->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $tiposProducto = TipoProducto::all();
        $proveedores = Proveedor::all();
        $detalles = DetalleProducto::all();
        $precios = Precio::all();

        return view('productos.create', compact('tiposProducto','proveedores','detalles','precios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'id_tipoProducto' => 'nullable|exists:tipoproducto,id',
            'id_proveedor' => 'nullable|exists:proveedor,id',
            'id_detalleProducto' => 'nullable|exists:detalleproducto,id',
            'id_precio' => 'nullable|exists:precio,id',
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $tiposProducto = TipoProducto::all();
        $proveedores = Proveedor::all();
        $detalles = DetalleProducto::all();
        $precios = Precio::all();

        return view('productos.edit', compact('producto','tiposProducto','proveedores','detalles','precios'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'id_tipoProducto' => 'nullable|exists:tipoproducto,id',
            'id_proveedor' => 'nullable|exists:proveedor,id',
            'id_detalleProducto' => 'nullable|exists:detalleproducto,id',
            'id_precio' => 'nullable|exists:precio,id',
        ]);

        $producto->update($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}

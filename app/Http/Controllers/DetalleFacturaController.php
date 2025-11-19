<?php

namespace App\Http\Controllers;

use App\Models\DetalleFactura;
use App\Models\Factura;
use App\Models\Producto;
use Illuminate\Http\Request;

class DetalleFacturaController extends Controller
{
    public function index()
    {
        $detalles = DetalleFactura::all();
        return view('detallefacturas.index', compact('detalles'));
    }

    public function create()
    {
        $facturas = Factura::all();
        $productos = Producto::all();
        return view('detallefacturas.create', compact('facturas', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_factura' => 'required|exists:factura,id',
            'id_producto' => 'required|exists:producto,id',
            'cantidad' => 'required|integer|min:1',
            'preciounitario' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        DetalleFactura::create($request->all());
        return redirect()->route('detallefacturas.index')->with('success', 'Detalle de factura creado correctamente.');
    }

    public function edit(DetalleFactura $detallefactura)
    {
        $facturas = Factura::all();
        $productos = Producto::all();
        return view('detallefacturas.edit', compact('detallefactura', 'facturas', 'productos'));
    }

    public function update(Request $request, DetalleFactura $detallefactura)
    {
        $request->validate([
            'id_factura' => 'required|exists:factura,id',
            'id_producto' => 'required|exists:producto,id',
            'cantidad' => 'required|integer|min:1',
            'preciounitario' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        $detallefactura->update($request->all());
        return redirect()->route('detallefacturas.index')->with('success', 'Detalle de factura actualizado correctamente.');
    }

    public function destroy(DetalleFactura $detallefactura)
    {
        $detallefactura->delete();
        return redirect()->route('detallefacturas.index')->with('success', 'Detalle de factura eliminado correctamente.');
    }
}

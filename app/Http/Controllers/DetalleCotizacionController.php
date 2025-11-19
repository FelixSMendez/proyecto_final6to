<?php

namespace App\Http\Controllers;

use App\Models\DetalleCotizacion;
use App\Models\Cotizacion;
use App\Models\Producto;
use Illuminate\Http\Request;

class DetalleCotizacionController extends Controller
{
    public function index()
    {
        $detalles = DetalleCotizacion::all();
        return view('detallecotizaciones.index', compact('detalles'));
    }

    public function create()
    {
        $cotizaciones = Cotizacion::all();
        $productos = Producto::all();
        return view('detallecotizaciones.create', compact('cotizaciones', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cotizacion' => 'required|exists:cotizacion,id',
            'id_producto' => 'required|exists:producto,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        DetalleCotizacion::create($request->all());
        return redirect()->route('detallecotizaciones.index')->with('success', 'Detalle de cotización creado correctamente.');
    }

    public function edit(DetalleCotizacion $detallecotizacion)
    {
        $cotizaciones = Cotizacion::all();
        $productos = Producto::all();
        return view('detallecotizaciones.edit', compact('detallecotizacion', 'cotizaciones', 'productos'));
    }

    public function update(Request $request, DetalleCotizacion $detallecotizacion)
    {
        $request->validate([
            'id_cotizacion' => 'required|exists:cotizacion,id',
            'id_producto' => 'required|exists:producto,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        $detallecotizacion->update($request->all());
        return redirect()->route('detallecotizaciones.index')->with('success', 'Detalle de cotización actualizado correctamente.');
    }

    public function destroy(DetalleCotizacion $detallecotizacion)
    {
        $detallecotizacion->delete();
        return redirect()->route('detallecotizaciones.index')->with('success', 'Detalle de cotización eliminado correctamente.');
    }
}

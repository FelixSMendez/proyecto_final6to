<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Factura;
use App\Models\TipoPago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::all();
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $facturas = Factura::all();
        $tipopagos = TipoPago::all();
        return view('pagos.create', compact('facturas', 'tipopagos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_factura' => 'required|exists:factura,id',
            'monto' => 'required|numeric',
        ]);

        Pago::create($request->all());
        return redirect()->route('pagos.index')->with('success', 'Pago creado correctamente.');
    }

    public function edit(Pago $pago)
    {
        $facturas = Factura::all();
        $tipopagos = TipoPago::all();
        return view('pagos.edit', compact('pago', 'facturas', 'tipopagos'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'id_factura' => 'required|exists:factura,id',
            'monto' => 'required|numeric',
        ]);

        $pago->update($request->all());
        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }
}

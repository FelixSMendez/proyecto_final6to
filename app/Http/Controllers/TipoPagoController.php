<?php

namespace App\Http\Controllers;

use App\Models\TipoPago;
use Illuminate\Http\Request;

class TipoPagoController extends Controller
{
    public function index()
    {
        $tipopagos = TipoPago::all();
        return view('tipopagos.index', compact('tipopagos'));
    }

    public function create()
    {
        return view('tipopagos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:200',
        ]);

        TipoPago::create($request->all());
        return redirect()->route('tipopagos.index')->with('success', 'Tipo de pago creado correctamente.');
    }

    public function edit(TipoPago $tipopago)
    {
        return view('tipopagos.edit', compact('tipopago'));
    }

    public function update(Request $request, TipoPago $tipopago)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:200',
        ]);

        $tipopago->update($request->all());
        return redirect()->route('tipopagos.index')->with('success', 'Tipo de pago actualizado correctamente.');
    }

    public function destroy(TipoPago $tipopago)
    {
        $tipopago->delete();
        return redirect()->route('tipopagos.index')->with('success', 'Tipo de pago eliminado correctamente.');
    }
}

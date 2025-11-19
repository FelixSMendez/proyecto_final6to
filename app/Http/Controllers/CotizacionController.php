<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Cliente;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::all();
        return view('cotizaciones.index', compact('cotizaciones'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('cotizaciones.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'nullable|exists:cliente,id',
            'fecha' => 'nullable|date',
            'total' => 'nullable|numeric',
        ]);

        Cotizacion::create($request->all());
        return redirect()->route('cotizaciones.index')->with('success', 'Cotización creada correctamente.');
    }

    public function edit(Cotizacion $cotizacion)
    {
        $clientes = Cliente::all();
        return view('cotizaciones.edit', compact('cotizacion', 'clientes'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        $request->validate([
            'id_cliente' => 'nullable|exists:cliente,id',
            'fecha' => 'nullable|date',
            'total' => 'nullable|numeric',
        ]);

        $cotizacion->update($request->all());
        return redirect()->route('cotizaciones.index')->with('success', 'Cotización actualizada correctamente.');
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();
        return redirect()->route('cotizaciones.index')->with('success', 'Cotización eliminada correctamente.');
    }
}

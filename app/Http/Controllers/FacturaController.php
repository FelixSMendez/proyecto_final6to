<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::all();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        $sucursales = Sucursal::all();
        return view('facturas.create', compact('clientes', 'empleados', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'correlativo' => 'required|integer',
            'letra_serie' => 'nullable|string|size:1',
            'fecha' => 'required|date',
            'id_cliente' => 'required|exists:cliente,id',
            'id_empleado' => 'required|exists:empleado,id',
            'id_sucursal' => 'required|exists:sucursal,id',
        ]);

        Factura::create($request->all());
        return redirect()->route('facturas.index')->with('success', 'Factura creada correctamente.');
    }

    public function edit(Factura $factura)
    {
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        $sucursales = Sucursal::all();
        return view('facturas.edit', compact('factura', 'clientes', 'empleados', 'sucursales'));
    }

    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'correlativo' => 'required|integer',
            'letra_serie' => 'nullable|string|size:1',
            'fecha' => 'required|date',
            'id_cliente' => 'required|exists:cliente,id',
            'id_empleado' => 'required|exists:empleado,id',
            'id_sucursal' => 'required|exists:sucursal,id',
        ]);

        $factura->update($request->all());
        return redirect()->route('facturas.index')->with('success', 'Factura actualizada correctamente.');
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada correctamente.');
    }
}

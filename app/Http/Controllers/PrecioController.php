<?php

namespace App\Http\Controllers;

use App\Models\Precio;
use App\Models\TipoMedida;
use Illuminate\Http\Request;

class PrecioController extends Controller
{
    public function index()
    {
        $precios = Precio::with('tipoMedida')->get();
        return view('precios.index', compact('precios'));
    }

    public function create()
    {
        $tiposMedida = TipoMedida::all();
        return view('precios.create', compact('tiposMedida'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'nullable|string|max:50',
            'precioVenta' => 'nullable|numeric',
            'descuento' => 'nullable|numeric',
            'id_tipoMedida' => 'nullable|exists:tipomedida,id',
        ]);

        Precio::create($request->all());
        return redirect()->route('precios.index')->with('success', 'Precio creado correctamente.');
    }

    public function edit(Precio $precio)
    {
        $tiposMedida = TipoMedida::all();
        return view('precios.edit', compact('precio', 'tiposMedida'));
    }

    public function update(Request $request, Precio $precio)
    {
        $request->validate([
            'tipo' => 'nullable|string|max:50',
            'precioVenta' => 'nullable|numeric',
            'descuento' => 'nullable|numeric',
            'id_tipoMedida' => 'nullable|exists:tipomedida,id',
        ]);

        $precio->update($request->all());
        return redirect()->route('precios.index')->with('success', 'Precio actualizado correctamente.');
    }

    public function destroy(Precio $precio)
    {
        $precio->delete();
        return redirect()->route('precios.index')->with('success', 'Precio eliminado correctamente.');
    }
}

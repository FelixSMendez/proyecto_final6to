<?php

namespace App\Http\Controllers;

use App\Models\TipoMedida;
use Illuminate\Http\Request;

class TipoMedidaController extends Controller
{
    public function index()
    {
        $tipomedidas = TipoMedida::paginate(15);
        return view('tipomedidas.index', compact('tipomedidas'));
    }

    public function create()
    {
        return view('tipomedidas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string|max:200',
        ]);

        TipoMedida::create($request->all());

        return redirect()->route('tipomedidas.index')->with('success', 'Tipo de medida creado correctamente.');
    }

    public function edit(TipoMedida $tipomedida)
    {
        return view('tipomedidas.edit', compact('tipomedida'));
    }

    public function update(Request $request, TipoMedida $tipomedida)
    {
        $request->validate([
            'tipo' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string|max:200',
        ]);

        $tipomedida->update($request->all());

        return redirect()->route('tipomedidas.index')->with('success', 'Tipo de medida actualizado correctamente.');
    }

    public function destroy(TipoMedida $tipomedida)
    {
        $tipomedida->delete();
        return redirect()->route('tipomedidas.index')->with('success', 'Tipo de medida eliminado correctamente.');
    }
}

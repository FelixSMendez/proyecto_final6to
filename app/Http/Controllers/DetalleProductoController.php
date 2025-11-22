<?php

namespace App\Http\Controllers;

use App\Models\DetalleProducto;
use App\Models\Producto;
use App\Models\TipoMedida;
use App\Models\Marca;
use Illuminate\Http\Request;

class DetalleProductoController extends Controller
{
    public function index()
    {
        $detalles = DetalleProducto::with(['producto', 'marca', 'tipoMedida'])->paginate(10);
        return view('detalleproductos.index', compact('detalles'));
    }

    public function create()
    {
        $productos = Producto::all();
        $marcas = Marca::all();
        $medidas = TipoMedida::all();
        return view('detalleproductos.create', compact('productos', 'marcas', 'medidas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:producto,id',      
            'id_marca' => 'required|exists:marcas,id',           
            'id_tipoMedida' => 'required|exists:tipomedida,id',
            'color_acabado' => 'nullable|string|max:100',        
            'descripcion' => 'nullable|string|max:200',
        ]);

        DetalleProducto::create($request->all());
        return redirect()->route('detalleproductos.index')->with('success', 'Detalle de producto creado correctamente.');
    }

    public function edit(DetalleProducto $detalleproducto)
    {
        $productos = Producto::all();
        $marcas = Marca::all();
        $medidas = TipoMedida::all();
        return view('detalleproductos.edit', compact('detalleproducto', 'productos', 'marcas', 'medidas'));
    }

    public function update(Request $request, DetalleProducto $detalleproducto)
    {
        $request->validate([
            'id_producto' => 'required|exists:producto,id',      
            'id_marca' => 'required|exists:marcas,id',           
            'id_tipoMedida' => 'required|exists:tipomedida,id',
            'color_acabado' => 'nullable|string|max:100',        
            'descripcion' => 'nullable|string|max:200',
        ]);

        $detalleproducto->update($request->all());
        return redirect()->route('detalleproductos.index')->with('success', 'Detalle de producto actualizado correctamente.');
    }

    public function destroy(DetalleProducto $detalleproducto)
    {
        $detalleproducto->delete();
        return redirect()->route('detalleproductos.index')->with('success', 'Detalle de producto eliminado correctamente.');
    }
}

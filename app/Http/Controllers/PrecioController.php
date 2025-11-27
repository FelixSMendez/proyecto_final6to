<?php

namespace App\Http\Controllers;

use App\Models\Precio;
use App\Models\DetalleProducto;
use Illuminate\Http\Request;

class PrecioController extends Controller
{
    /**
     * Mostrar lista de precios
     */
    public function index()
    {
        $precios = Precio::with('detalleProducto.producto', 'detalleProducto.marca', 'detalleProducto.tipoMedida')
            ->orderBy('id_detalleproducto')
            ->paginate(15);
        
        return view('precios.index', compact('precios'));
    }

    /**
     * Crear nuevo precio
     */
    public function create()
    {
        $detallesProductos = DetalleProducto::with('producto', 'marca', 'tipoMedida')
            ->orderBy('id')
            ->get();
        
        return view('precios.create', compact('detallesProductos'));
    }

    /**
     * Guardar nuevo precio
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_detalleproducto' => 'required|exists:detalleproducto,id',
            'tipo'               => 'nullable|string|max:50',
            'cantidadminima'     => 'nullable|integer|min:0',
            'cantidadmaxima'     => 'nullable|integer|min:0',
            'precioVenta'        => 'required|numeric|min:0',
            'tipo_cliente'       => 'required|in:minorista,mayorista,distribuidor',
        ]);

        // Validar que cantidadmaxima >= cantidadminima si ambas existen
        if ($request->cantidadminima && $request->cantidadmaxima) {
            if ($request->cantidadmaxima < $request->cantidadminima) {
                return back()->withErrors(['cantidadmaxima' => 'Cantidad máxima debe ser >= cantidad mínima'])
                    ->withInput();
            }
        }

        Precio::create($request->all());
        
        return redirect()->route('precios.index')
            ->with('success', 'Precio creado correctamente.');
    }

    /**
     * Editar precio
     */
    public function edit(Precio $precio)
    {
        $detallesProductos = DetalleProducto::with('producto', 'marca', 'tipoMedida')
            ->orderBy('id')
            ->get();
        
        return view('precios.edit', compact('precio', 'detallesProductos'));
    }

    /**
     * Actualizar precio
     */
    public function update(Request $request, Precio $precio)
    {
        $request->validate([
            'id_detalleproducto' => 'required|exists:detalleproducto,id',
            'tipo'               => 'nullable|string|max:50',
            'cantidadminima'     => 'nullable|integer|min:0',
            'cantidadmaxima'     => 'nullable|integer|min:0',
            'precioVenta'        => 'required|numeric|min:0',
            'tipo_cliente'       => 'required|in:minorista,mayorista,distribuidor',
        ]);

        // Validar que cantidadmaxima >= cantidadminima si ambas existen
        if ($request->cantidadminima && $request->cantidadmaxima) {
            if ($request->cantidadmaxima < $request->cantidadminima) {
                return back()->withErrors(['cantidadmaxima' => 'Cantidad máxima debe ser >= cantidad mínima'])
                    ->withInput();
            }
        }

        $precio->update($request->all());
        
        return redirect()->route('precios.index')
            ->with('success', 'Precio actualizado correctamente.');
    }

    /**
     * Eliminar precio
     */
    public function destroy(Precio $precio)
    {
        $precio->delete();
        return redirect()->route('precios.index')
            ->with('success', 'Precio eliminado correctamente.');
    }
}
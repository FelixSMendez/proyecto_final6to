<?php

namespace App\Http\Controllers;

use App\Models\DetalleProducto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    /**
     * Ver carrito
     */
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = $this->calcularTotal($carrito);

        return view('carrito.index', compact('carrito', 'total'));
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar(Request $request, $id)
{
    $detalle = \App\Models\DetalleProducto::with('producto')->findOrFail($id);

    $carrito = session()->get('carrito', []);

    // Buscar sucursal con stock (por defecto la primera)
    $inventario = \App\Models\Inventario::where('id_detalleproducto', $id)
        ->with('sucursal')
        ->where('stock_actual', '>', 0)
        ->first();

    if (!$inventario) {
        return back()->with('error', 'No hay stock disponible para este producto en ninguna sucursal.');
    }

    if (!isset($carrito[$id])) {
        $carrito[$id] = [
            'id_detalle' => $id,
            'nombre' => $detalle->producto->nombre,
            'marca' => $detalle->producto->marca->nombre ?? '',
            'medida' => $detalle->medida->nombre ?? '',
            'color' => $detalle->color ?? '',
            'precio' => $detalle->obtenerPrecio('minorista'),
            'cantidad' => 0,
            'id_sucursal' => $inventario->id_sucursal, 
        ];
    }

    $carrito[$id]['cantidad'] += 1;

    session()->put('carrito', $carrito);

    return back()->with('success', 'Producto agregado al carrito');
}

public function cambiarSucursal(Request $request, $id)
{
    $request->validate([
        'id_sucursal' => 'required|exists:sucursal,id',
    ]);

    $carrito = session()->get('carrito', []);

    if (isset($carrito[$id])) {
        $carrito[$id]['id_sucursal'] = (int)$request->id_sucursal;
        session()->put('carrito', $carrito);
    }

    return back();
}

    /**
     * Actualizar cantidad en carrito
     */
    public function actualizar(Request $request, $id)
    {
        $carrito = session()->get('carrito', []);
        $cantidad = $request->input('cantidad', 1);

        if (isset($carrito[$id])) {
            if ($cantidad <= 0) {
                unset($carrito[$id]);
            } else {
                $carrito[$id]['cantidad'] = $cantidad;
            }
        }

        session()->put('carrito', $carrito);

        return redirect()->back()->with('success', 'Carrito actualizado');
    }

    /**
     * Quitar producto del carrito
     */
    public function quitar($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
        }

        session()->put('carrito', $carrito);

        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }

    /**
     * Calcular total del carrito
     */
    private function calcularTotal($carrito)
    {
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }
}

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
    $detalleProducto = DetalleProducto::with(['producto', 'marca', 'tipoMedida', 'precios'])->findOrFail($id);
    $cantidad = $request->input('cantidad', 1);

    // Obtener precio correctamente
    $precio = $detalleProducto->precios()
        ->where('tipo_cliente', 'minorista')
        ->first()?->precioVenta ?? 0;

    $carrito = session()->get('carrito', []);

    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad'] += $cantidad;
    } else {
        $carrito[$id] = [
            'id_detalle' => $detalleProducto->id,
            'id_producto' => $detalleProducto->id_producto,
            'nombre' => $detalleProducto->producto->nombre,
            'descripcion' => $detalleProducto->descripcion,
            'marca' => $detalleProducto->marca->nombre ?? 'N/A',
            'medida' => $detalleProducto->tipoMedida->nombre ?? 'N/A',
            'color' => $detalleProducto->color_acabado,
            'precio' => $precio,  // ✅ AQUÍ VA EL PRECIO
            'cantidad' => $cantidad,
        ];
    }

    session()->put('carrito', $carrito);

    return redirect()->back()->with('success', 'Producto agregado al carrito');
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

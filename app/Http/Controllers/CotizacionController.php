<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\Cliente;
use App\Models\DetalleProducto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    // ✅ LISTAR COTIZACIONES
    public function index()
    {
        $cotizaciones = Cotizacion::with(['cliente', 'detalles'])->get();
        return view('cotizacion.index', compact('cotizaciones'));
    }

    // ✅ CREAR COTIZACIÓN DESDE CARRITO
    public function crear(Request $request)
    {
        // Obtener cliente autenticado
        $cliente_id = auth('cliente')->id() ?? $request->id_cliente;
        
        // Obtener carrito de la sesión
        $carrito = session('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->back()->with('error', 'El carrito está vacío');
        }

        // Calcular total
        $total = 0;
        foreach ($carrito as $item) {
            // CAST: garantizar que cantidad y precio sean números
            $cantidad = (int) ($item['cantidad'] ?? 0);
            $precio = (float) ($item['precio'] ?? 0);
            $descuento = (float) ($item['descuento'] ?? 0);
            
            $subtotal = ($precio * $cantidad) - $descuento;
            $total += $subtotal;
        }

        // Crear cotización
        $cotizacion = Cotizacion::create([
            'id_cliente' => (int) $cliente_id,
            'fecha' => now()->toDateString(),
            'fecha_vencimiento' => now()->addDays(15)->toDateString(),
            'total' => (float) $total,
            'estado' => 'pendiente'
        ]);

        // Agregar detalles
        foreach ($carrito as $item) {
            // CAST: garantizar tipos correctos
            $cantidad = (int) ($item['cantidad'] ?? 0);
            $precio = (float) ($item['precio'] ?? 0);
            $descuento = (float) ($item['descuento'] ?? 0);
            
            // 🔑 FLEXIBLE: Buscar id_detalleproducto de varias formas
            $idDetalleProducto = null;
            
            // Opción 1: Si existe directamente
            if (isset($item['id_detalleproducto'])) {
                $idDetalleProducto = (int) $item['id_detalleproducto'];
            }
            // Opción 2: Si existe id_producto, busca el primer detalleproducto
            elseif (isset($item['id_producto'])) {
                $detalle = DetalleProducto::where('id_producto', (int) $item['id_producto'])->first();
                $idDetalleProducto = $detalle ? $detalle->id : null;
            }
            // Opción 3: Si existe producto_id, busca el primer detalleproducto
            elseif (isset($item['producto_id'])) {
                $detalle = DetalleProducto::where('id_producto', (int) $item['producto_id'])->first();
                $idDetalleProducto = $detalle ? $detalle->id : null;
            }
            
            // Si no encontramos id_detalleproducto, saltar este item
            if (!$idDetalleProducto) {
                continue;
            }
            
            // Validar que el detalleproducto exista
            $detalleExiste = DetalleProducto::find($idDetalleProducto);
            if (!$detalleExiste) {
                continue;
            }
            
            $subtotal = ($precio * $cantidad) - $descuento;
            
            DetalleCotizacion::create([
                'id_cotizacion' => $cotizacion->id,
                'id_detalleproducto' => $idDetalleProducto,
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'subtotal' => (float) $subtotal
            ]);
        }

        // Limpiar carrito
        session()->forget('carrito');

        return redirect()->route('cotizacion.show', $cotizacion->id)
                        ->with('success', 'Cotización creada exitosamente');
    }

    // ✅ VER DETALLES DE COTIZACIÓN
    public function show($id)
    {
        $cotizacion = Cotizacion::with(['cliente', 'detalles.detalleProducto.producto'])->findOrFail($id);
        return view('cotizacion.show', compact('cotizacion'));
    }

    // ✅ CAMBIAR ESTADO DE COTIZACIÓN
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,aceptada,rechazada,vencida'
        ]);

        $cotizacion = Cotizacion::findOrFail($id);
        $cotizacion->update(['estado' => $request->estado]);

        return redirect()->back()->with('success', 'Estado actualizado');
    }

    // ✅ DESCARGAR PDF DE COTIZACIÓN
    public function descargarPDF($id)
    {
        $cotizacion = Cotizacion::with(['detalles.detalleProducto.producto', 'cliente'])->findOrFail($id);

        // Convertir logo a base64
        $logoPath = public_path('images/logo-paints.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $pdf = Pdf::loadView('pdf.cotizacion', compact('cotizacion', 'logoBase64'));

        return $pdf->download('Cotizacion_' . $cotizacion->id . '.pdf');
    }

    // ✅ ELIMINAR COTIZACIÓN
    public function destroy($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $cotizacion->delete();

        return redirect()->route('cotizacion.index')->with('success', 'Cotización eliminada');
    }
}

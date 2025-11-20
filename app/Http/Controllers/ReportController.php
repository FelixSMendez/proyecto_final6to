<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Pago;
use App\Models\DetalleProducto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // 📊 REPORTE 1: Total facturado por tipo de pago entre 2 fechas
    public function totalPorMedioPago(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $pagos = Pago::whereHas('factura', function ($query) use ($request) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        })
        ->with('tipoPago', 'factura')
        ->get()
        ->groupBy('id_tipo_pago');

        $totales = [];
        foreach ($pagos as $tipo_pago_id => $registros) {
            $tipo = $registros->first()->tipoPago->nombre;
            $monto = $registros->sum('monto');
            $totales[$tipo] = $monto;
        }

        return response()->json([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'totales' => $totales,
            'total_general' => array_sum($totales)
        ]);
    }

    // 📊 REPORTE 2: Productos que más dinero generan entre 2 fechas
    public function productosPorIngresos(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $detalles = DetalleFactura::whereHas('factura', function ($query) use ($request) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        })
        ->with('detalleProducto.producto')
        ->get();

        $productos = [];
        foreach ($detalles as $detalle) {
            $nombre = $detalle->detalleProducto->producto->nombre;
            $ingreso = ($detalle->precio_unitario * $detalle->cantidad) - ($detalle->descuento_aplicado ?? 0);
            
            if (isset($productos[$nombre])) {
                $productos[$nombre] += $ingreso;
            } else {
                $productos[$nombre] = $ingreso;
            }
        }

        arsort($productos);

        return response()->json([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'productos' => $productos
        ]);
    }

    // 📊 REPORTE 3: Productos más vendidos por cantidad
    public function productosPorCantidad(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $detalles = DetalleFactura::whereHas('factura', function ($query) use ($request) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        })
        ->with('detalleProducto.producto')
        ->get();

        $productos = [];
        foreach ($detalles as $detalle) {
            $nombre = $detalle->detalleProducto->producto->nombre;
            
            if (isset($productos[$nombre])) {
                $productos[$nombre] += $detalle->cantidad;
            } else {
                $productos[$nombre] = $detalle->cantidad;
            }
        }

        arsort($productos);

        return response()->json([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'productos' => $productos
        ]);
    }

    // 📊 REPORTE 4: Inventario actual general
    public function inventarioActual()
    {
        $detalles = DetalleProducto::with('producto', 'tienda', 'marca')
            ->where('cantidad_stock', '>', 0)
            ->get();

        $inventario = [];
        foreach ($detalles as $detalle) {
            $key = $detalle->producto->nombre;
            if (!isset($inventario[$key])) {
                $inventario[$key] = [
                    'producto_id' => $detalle->producto->id,
                    'cantidad_total' => 0,
                    'tiendas' => []
                ];
            }
            $inventario[$key]['cantidad_total'] += $detalle->cantidad_stock;
            $inventario[$key]['tiendas'][$detalle->tienda->nombre] = $detalle->cantidad_stock;
        }

        return response()->json($inventario);
    }

    // 📊 REPORTE 5: Productos con menos ventas
    public function productosMenosVendidos(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $detalles = DetalleFactura::whereHas('factura', function ($query) use ($request) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        })
        ->with('detalleProducto.producto')
        ->get();

        $productos = [];
        foreach ($detalles as $detalle) {
            $nombre = $detalle->detalleProducto->producto->nombre;
            if (isset($productos[$nombre])) {
                $productos[$nombre] += $detalle->cantidad;
            } else {
                $productos[$nombre] = $detalle->cantidad;
            }
        }

        asort($productos);

        return response()->json([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'productos' => $productos
        ]);
    }

    // 📊 REPORTE 6: Productos sin stock
    public function productosSinStock()
    {
        $detalles = DetalleProducto::with('producto', 'tienda')
            ->where('cantidad_stock', '<=', 0)
            ->get();

        $productosAgrupados = [];
        foreach ($detalles as $detalle) {
            $nombre = $detalle->producto->nombre;
            if (!isset($productosAgrupados[$nombre])) {
                $productosAgrupados[$nombre] = [];
            }
            $productosAgrupados[$nombre][] = $detalle->tienda->nombre;
        }

        return response()->json($productosAgrupados);
    }

    // 📊 REPORTE 7: Búsqueda de factura por número
    public function buscarFactura($numero_factura)
    {
        $factura = Factura::with(['detalles', 'pagos', 'cliente', 'empleado'])
            ->where('correlativo', $numero_factura)
            ->orWhere('letra_serie', $numero_factura)
            ->first();

        if (!$factura) {
            return response()->json(['error' => 'Factura no encontrada'], 404);
        }

        return response()->json($factura);
    }

    // 📊 REPORTE 8: Ingresos al inventario (compras a proveedores)
    public function ingresosInventario(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        // Nota: Necesita tabla de ingresos creada
        // Por ahora retornamos estructura base
        return response()->json([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'mensaje' => 'Tabla de ingresos aún no creada'
        ]);
    }

    // 📊 REPORTE 9: Productos bajo stock mínimo
    public function productosBaroStock()
    {
        $detalles = DetalleProducto::with('producto', 'tienda')
        ->whereRaw('cantidad_stock <= (SELECT cantidad_minima FROM productos WHERE productos.id = detalle_producto.id_producto)')
        ->get();

        $alertas = [];
        foreach ($detalles as $detalle) {
            $alertas[] = [
                'producto' => $detalle->producto->nombre,
                'tienda' => $detalle->tienda->nombre,
                'cantidad_actual' => $detalle->cantidad_stock,
                'cantidad_minima' => $detalle->producto->cantidad_minima,
                'accion' => 'Reorden urgente'
            ];
        }

        return response()->json($alertas);
    }

    // 📊 REPORTE 10: Inventario por tienda
    public function inventarioPorTienda($id_tienda)
    {
        $detalles = DetalleProducto::with('producto')
            ->where('id_tienda', $id_tienda)
            ->where('cantidad_stock', '>', 0)
            ->get();

        $inventario = [];
        $total_cantidad = 0;
        $total_valor = 0;

        foreach ($detalles as $detalle) {
            $valor = $detalle->cantidad_stock * $detalle->producto->precio_unitario;
            $inventario[] = [
                'producto' => $detalle->producto->nombre,
                'cantidad' => $detalle->cantidad_stock,
                'precio_unitario' => $detalle->producto->precio_unitario,
                'valor_total' => $valor
            ];
            $total_cantidad += $detalle->cantidad_stock;
            $total_valor += $valor;
        }

        return response()->json([
            'tienda_id' => $id_tienda,
            'inventario' => $inventario,
            'total_cantidad' => $total_cantidad,
            'total_valor' => $total_valor
        ]);
    }
}

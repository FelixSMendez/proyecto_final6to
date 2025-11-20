<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Pago;
use App\Models\Inventario;
use App\Models\Lote;
use App\Models\Sucursal;
use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GerenceController extends Controller
{
    // ✅ DASHBOARD DEL GERENTE
    public function dashboard()
    {
        $hoy = Carbon::today();
        
        $totalFacturado = Factura::whereDate('fecha', $hoy)
                                  ->where('estado', '!=', 'anulada')
                                  ->sum('total');
        
        $totalFacturas = Factura::whereDate('fecha', $hoy)
                                ->where('estado', '!=', 'anulada')
                                ->count();
        
        $totalPendiente = Factura::where('estado', 'pendiente')->sum('total');
        
        $totalAnuladas = Factura::where('estado', 'anulada')->count();

        return view('dashboard.gerente', compact(
            'totalFacturado',
            'totalFacturas',
            'totalPendiente',
            'totalAnuladas'
        ));
    }

    // ========================================
    // 📊 REPORTES - RETORNA VISTAS
    // ========================================

    // ✅ REPORTE 1: Total facturado por tipo de pago
    public function reporteMonto(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $fechaInicio = $request->query('fecha_inicio', now()->format('Y-m-d'));
        $fechaFin = $request->query('fecha_fin', now()->format('Y-m-d'));

        $pagos = Pago::whereHas('factura', function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin])
                  ->where('estado', '!=', 'anulada');
        })
        ->with('tipoPago')
        ->get()
        ->groupBy('id_tipo_pago');

        $data = [];
        foreach ($pagos as $tipo_pago_id => $registros) {
            $tipo = $registros->first()->tipoPago->nombre ?? 'Sin especificar';
            $monto = $registros->sum('monto');
            $data[] = [
                'medio' => $tipo,
                'total' => $monto,
                'cantidad' => $registros->count(),
            ];
        }

        return view('gerente.reportes.reporte-monto', ['data' => $data]);
    }

    // ✅ REPORTE 2: Productos que más dinero generan
    public function reporteIngresos(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date',
    ]);

    $fechaInicio = $request->query('fecha_inicio', now()->format('Y-m-d'));
    $fechaFin = $request->query('fecha_fin', now()->format('Y-m-d'));

    $detalles = DetalleFactura::whereHas('factura', function ($query) use ($fechaInicio, $fechaFin) {
        $query->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->where('estado', '!=', 'anulada');
    })
    ->with('detalleProducto.producto')
    ->get();

    $productos = [];
    foreach ($detalles as $detalle) {
        $nombre = $detalle->detalleProducto?->producto?->nombre ?? 'Sin nombre';
        $ingreso = $detalle->subtotal;

        if (!isset($productos[$nombre])) {
            $productos[$nombre] = [
                'producto' => $nombre,
                'total' => 0,
                'cantidad' => 0,
            ];
        }
        $productos[$nombre]['total'] += $ingreso;
        $productos[$nombre]['cantidad'] += $detalle->cantidad;
    }

    // Ordenar por total descendente y tomar top 10
    usort($productos, function ($a, $b) {
        return $b['total'] <=> $a['total'];
    });

    $data = array_slice(array_values($productos), 0, 10);

    return view('gerente.reportes.reporte-ingresos', ['data' => $data]);
}

    // ✅ REPORTE 3: Productos más vendidos por cantidad
    public function reporteVendidos(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $fechaInicio = $request->query('fecha_inicio', now()->format('Y-m-d'));
        $fechaFin = $request->query('fecha_fin', now()->format('Y-m-d'));

        $detalles = DetalleFactura::whereHas('factura', function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin])
                  ->where('estado', '!=', 'anulada');
        })
        ->with('detalleProducto.producto')
        ->get();

        $productos = [];
        foreach ($detalles as $detalle) {
            $nombre = $detalle->detalleProducto?->producto?->nombre ?? 'Sin nombre';
            
            if (!isset($productos[$nombre])) {
                $productos[$nombre] = [
                    'producto' => $nombre,
                    'cantidad' => 0,
                    'total' => 0,
                ];
            }
            
            $productos[$nombre]['cantidad'] += $detalle->cantidad;
            $productos[$nombre]['total'] += $detalle->subtotal;
        }

        // Ordenar por cantidad descendente y tomar top 10
        usort($productos, function ($a, $b) {
            return $b['cantidad'] <=> $a['cantidad'];
        });
        
        $data = array_slice(array_values($productos), 0, 10);

        return view('gerente.reportes.reporte-vendidos', ['data' => $data]);
    }

    // ✅ REPORTE 4: Inventario actual general
    public function reporteInventario()
    {
        $inventario = Inventario::with('detalleProducto.producto')
            ->get()
            ->groupBy(function($item) {
                return $item->detalleProducto?->producto?->nombre ?? 'Sin nombre';
            })
            ->map(function($group) {
                return [
                    'producto' => $group->first()->detalleProducto?->producto?->nombre ?? 'Sin nombre',
                    'stock_actual' => $group->sum('stock_actual'),
                    'stock_minimo' => $group->first()?->stock_minimo ?? 5,
                    'unidad' => $group->first()->detalleProducto?->producto?->unidad ?? 'N/A',
                ];
            })
            ->values()
            ->toArray();

        return view('gerente.reportes.reporte-inventario', ['inventario' => $inventario]);
    }

    // ✅ REPORTE 5: Inventario por tienda
    public function reporteInventarioTienda($id = null)
    {
        $sucursales = Sucursal::all();
        $data = [];
        $tiendaSeleccionada = null;

        if ($id) {
            $tiendaSeleccionada = Sucursal::find($id);
            
            if ($tiendaSeleccionada) {
                $data = Inventario::where('id_sucursal', $id)
                    ->with('detalleProducto.producto')
                    ->get()
                    ->map(function($item) {
                        return [
                            'producto' => $item->detalleProducto?->producto?->nombre ?? 'Sin nombre',
                            'stock_actual' => $item->stock_actual,
                            'unidad' => $item->detalleProducto?->producto?->unidad ?? 'N/A',
                        ];
                    })
                    ->toArray();
            }
        }

        return view('gerente.reportes.reporte-inventario-tienda', ['sucursales' => $sucursales, 'data' => $data, 'tiendaSeleccionada' => $tiendaSeleccionada]);
    }

    // ✅ REPORTE 6: Productos menos vendidos
    public function reporteMenosVendidos(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $fechaInicio = $request->query('fecha_inicio', now()->format('Y-m-d'));
        $fechaFin = $request->query('fecha_fin', now()->format('Y-m-d'));

        $detalles = DetalleFactura::whereHas('factura', function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin])
                  ->where('estado', '!=', 'anulada');
        })
        ->with('detalleProducto.producto')
        ->get();

        $productos = [];
        foreach ($detalles as $detalle) {
            $nombre = $detalle->detalleProducto?->producto?->nombre ?? 'Sin nombre';
            
            if (!isset($productos[$nombre])) {
                $productos[$nombre] = [
                    'producto' => $nombre,
                    'cantidad' => 0,
                    'total' => 0,
                ];
            }
            
            $productos[$nombre]['cantidad'] += $detalle->cantidad;
            $productos[$nombre]['total'] += $detalle->subtotal;
        }

        // Ordenar por cantidad ascendente y tomar top 10
        usort($productos, function ($a, $b) {
            return $a['cantidad'] <=> $b['cantidad'];
        });
        
        $data = array_slice(array_values($productos), 0, 10);

        return view('gerente.reportes.reporte-menos-vendidos', ['data' => $data]);
    }

    // ✅ REPORTE 7: Productos sin stock
    public function reporteSinStock()
    {
        $productos = Inventario::where('stock_actual', 0)
            ->with('detalleProducto.producto', 'sucursal')
            ->get()
            ->map(function($item) {
                return [
                    'producto' => $item->detalleProducto?->producto?->nombre ?? 'Sin nombre',
                    'stock_actual' => $item->stock_actual,
                    'sucursal' => $item->sucursal?->nombre ?? 'N/A',
                ];
            })
            ->toArray();

        return view('gerente.reportes.reporte-sin-stock', ['productos' => $productos]);
    }

    // ✅ REPORTE 8: Stock mínimo
    public function reporteStockMinimo()
    {
        $alertas = Inventario::whereRaw('stock_actual <= stock_minimo')
            ->with('detalleProducto.producto', 'sucursal')
            ->get()
            ->map(function($item) {
                return [
                    'producto' => $item->detalleProducto?->producto?->nombre ?? 'Sin nombre',
                    'stock_actual' => $item->stock_actual,
                    'stock_minimo' => $item->stock_minimo,
                    'sucursal' => $item->sucursal?->nombre ?? 'N/A',
                ];
            })
            ->toArray();

        return view('gerente.reportes.reporte-stock-minimo', ['alertas' => $alertas]);
    }

    // ✅ REPORTE 9: Buscar factura por número
    public function reporteBuscarFactura(Request $request)
{
    $factura = null;
    
    if ($request->has('numero') && $request->numero) {
        $factura = Factura::with([
                'detalles.detalleProducto.producto',
                'pagos.tipoPago',
                'cliente'
            ])
            ->where('id', $request->numero)
            ->orWhere('correlativo', $request->numero)
            ->first();

        if ($factura) {
            if ($factura->fecha instanceof \DateTime) {
                $factura->fecha = $factura->fecha->format('Y-m-d H:i:s');
            }
            if ($factura->created_at instanceof \DateTime) {
                $factura->created_at = $factura->created_at->format('Y-m-d H:i:s');
            }
            //$factura = $factura->toArray();
        } else {
            $factura = null;
        }
    }
    return view('gerente.reportes.reporte-buscar-factura', ['factura' => $factura]);
}

    // ✅ REPORTE 10: Ingresos al inventario (reabastecimiento por lotes)
    public function reporteIngresosInv(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $fechaInicio = $request->query('fecha_inicio', now()->format('Y-m-d'));
        $fechaFin = $request->query('fecha_fin', now()->format('Y-m-d'));

        $data = Lote::whereBetween('fechaEntrada', [$fechaInicio, $fechaFin])
            ->with('detalleProducto.producto', 'proveedor', 'sucursal')
            ->get()
            ->map(function($item) {
                return [
                    'producto' => $item->detalleProducto?->producto?->nombre ?? 'Sin nombre',
                    'cantidad' => $item->cantidad,
                    'cantidad_actual' => $item->cantidad_actual,
                    'proveedor' => $item->proveedor?->nombre ?? 'N/A',
                    'sucursal' => $item->sucursal?->nombre ?? 'N/A',
                    'fecha_entrada' => $item->fechaEntrada,
                    'costo_unitario' => $item->costoUnidad,
                    'total_costo' => $item->cantidad * $item->costoUnidad,
                ];
            })
            ->toArray();

        return view('gerente.reportes.reporte-ingresos-inv', ['data' => $data]);
    }

    // ========================================
    //  ANULACIÓN DE FACTURAS
    // ========================================

    // ✅ LISTAR FACTURAS PARA ANULAR
public function facturasAnular()
{
    $facturas = Factura::with(['cliente', 'empleado'])
                      ->where('estado', '!=', 'anulada')
                      ->paginate(15);

    return view('gerente.facturas-anular', compact('facturas'));
}

// ✅ MOSTRAR FACTURA PARA ANULAR (CON DETALLES COMPLETOS)
public function mostrarFacturaAnular($id)
{
    $factura = Factura::with([
        'cliente',
        'detalles.detalleProducto.producto',
        'empleado',
        'empleadoAnulacion',
        'pagos.tipoPago'
    ])->findOrFail($id);
    
    // Validar que no esté ya anulada
    if ($factura->estado === 'anulada') {
        return redirect()->route('gerente.facturas-anular')
                       ->with('warning', 'Esta factura ya fue anulada');
    }

    return view('gerente.factura-anular-detalle', compact('factura'));
}

// ✅ ANULAR FACTURA (CON VALIDACIONES COMPLETAS)
public function anularFactura(Request $request, $id)
{
    // Validar entrada
    $validated = $request->validate([
        'razon_anulacion' => 'required|string|min:10|max:500'
    ], [
        'razon_anulacion.required' => 'La razón de anulación es obligatoria',
        'razon_anulacion.min' => 'La razón debe tener al menos 10 caracteres',
        'razon_anulacion.max' => 'La razón no puede exceder 500 caracteres'
    ]);

    try {
        $factura = Factura::findOrFail($id);

        // Validar que no esté ya anulada
        if ($factura->estado === 'anulada') {
            return redirect()->back()
                           ->with('error', 'Esta factura ya está anulada');
        }

        // Validar que el empleado esté autenticado
        $empleadoId = auth('employee')?->id();
        if (!$empleadoId) {
            return redirect()->back()
                           ->with('error', 'Error: No hay empleado autenticado');
        }

        // Actualizar la factura
        $factura->update([
            'estado' => 'anulada',
            'razon_anulacion' => $validated['razon_anulacion'],
            'fecha_anulacion' => now(),
            'id_empleado_anulacion' => $empleadoId
        ]);

        return redirect()->route('gerente.facturas-anular')
                        ->with('success', 'Factura #' . $factura->id . ' anulada correctamente');

    } catch (\Exception $e) {
        return redirect()->back()
                       ->with('error', 'Error al anular la factura: ' . $e->getMessage());
    }
}
}
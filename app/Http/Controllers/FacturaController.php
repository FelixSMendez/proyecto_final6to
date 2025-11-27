<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Pago;
use App\Models\TipoPago;
use App\Models\UsuarioCliente;
use App\Models\Inventario;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class FacturaController extends Controller
{
    /**
     * Crear factura DESDE WEB (Cliente)
     * NO requiere empleado, se genera automáticamente
     */
public function store(Request $request)
{
    $request->validate([
        'id_cliente' => 'required|exists:usuariosclientes,id',
    ]);

    $carrito = session()->get('carrito', []);
    
    if (empty($carrito)) {
        return back()->with('error', 'Carrito vacío');
    }

    // Calcular total
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    $idSucursal = 1; // por defecto
    $usuarioCliente = \App\Models\UsuarioCliente::with('cliente')->findOrFail($request->id_cliente);
    $tipoCliente = $usuarioCliente->cliente->tipo ?? 'minorista';

    // Prioridad 1: sucursal enviada por el front (si ya llamaste GPS/selección manual)
    if ($request->filled('id_sucursal_detectada')) {
        $idSucursal = (int) $request->id_sucursal_detectada;
    } 
    // Prioridad 2: si el cliente tiene lat/long guardados, calcula sucursal
    elseif ($usuarioCliente->cliente && $usuarioCliente->cliente->tieneGps()) {
        $resp = app(\App\Http\Controllers\SucursalGpsController::class)
            ->sucursalMasCercana(new Request([
                'lat' => $usuarioCliente->cliente->latitud,
                'lng' => $usuarioCliente->cliente->longitud,
            ]));

        $data = $resp->getData(true);
        if (!empty($data['ok']) && !empty($data['sucursal']['id'])) {
            $idSucursal = (int) $data['sucursal']['id'];
        }
    }

    // Crear factura SIN empleado (venta web)
    $factura = \App\Models\Factura::create([
        'correlativo'   => $this->generarCorrelativo(),
        'letra_serie'   => 'A',
        'fecha'         => now(),
        'id_cliente'    => $request->id_cliente,
        'id_empleado'   => auth('employee')->check() ? auth('employee')->id() : null,
        'id_sucursal'   => $idSucursal,
        'total'         => $total,
    ]);

    // Guardar detalles de factura (items del carrito)
    foreach ($carrito as $id => $item) {
        \App\Models\DetalleFactura::create([
            'id_factura'        => $factura->id,
            'id_detalleproducto'=> (int) $item['id_detalle'],
            'cantidad'          => (int) $item['cantidad'],
            'precio_unitario'   => (float) $item['precio'],
            'descuento_aplicado'=> 0,
            'subtotal'          => (float) $item['precio'] * (int) $item['cantidad'],
        ]);

        // Descontar stock de la sucursal seleccionada en el carrito
        $this->descontarStock(
            (int) $item['id_detalle'],
            (int) $item['cantidad'],
            (int) ($item['id_sucursal'] ?? 1)
        );
    }

    // Limpiar carrito
    session()->forget('carrito');

    return redirect()->route('factura.showPago', $factura->id);
}

    /**
     * Crear factura DESDE TIENDA (Empleado)
     * Requiere empleado y seleccionar cliente
     */
    public function createTienda(Request $request)
    {
        $clientes = UsuarioCliente::all();
        return view('factura.tienda.create', compact('clientes'));
    }

    /**
     * Guardar factura de tienda
     */
    public function storeTienda(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:usuariosclientes,id',
            'productos' => 'required|array',
            'productos.*.id_detalle' => 'required|exists:detalleproducto,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
        ]);

        $total = 0;
        $detalles = [];
        $sucursal_id = auth('employee')->user()->empleado->id_sucursal ?? 1;

        // Calcular total y obtener detalles
        foreach ($request->productos as $producto) {
            $detalle = \App\Models\DetalleProducto::find($producto['id_detalle']);
            $precio = $detalle->obtenerPrecio('minorista');
            $subtotal = $precio * $producto['cantidad'];
            $total += $subtotal;

            $detalles[] = [
                'id_detalle' => $producto['id_detalle'],
                'cantidad' => $producto['cantidad'],
                'precio' => $precio,
            ];
        }

        // Crear factura CON empleado (venta tienda)
        $factura = Factura::create([
    'correlativo' => $this->generarCorrelativo(),
    'letra_serie' => 'A',
    'fecha' => now(),
    'id_cliente' => $request->id_cliente,
    'id_empleado' => auth('employee')->id(),  
    'id_sucursal' => $sucursal_id,
    'total' => $total,
]);

        // Guardar detalles y descontar stock
        foreach ($detalles as $item) {
        DetalleFactura::create([
            'id_factura' => $factura->id,
            'id_detalleproducto' => $item['id_detalle'],
            'cantidad' => $item['cantidad'],
            'precio_unitario' => $item['precio'],
            'descuento_aplicado' => 0,
        ]);

        //  DESCONTAR DE LA SUCURSAL DEL EMPLEADO
        $this->descontarStock($item['id_detalle'], $item['cantidad'], $sucursal_id);
    }

    return redirect()->route('factura.showPago', $factura->id);

}

    /**
     * DESCONTAR STOCK AUTOMÁTICAMENTE
     */
    private function descontarStock($id_detalleproducto, $cantidad, $id_sucursal = null)
{
    try {
        // SI NO VIENE SUCURSAL, DETECTARLA AUTOMÁTICAMENTE
        if (!$id_sucursal) {
            // Si es empleado en tienda, usar su sucursal
            if (auth('employee')->check()) {
                $empleado = auth('employee')->user()->empleado;
                $id_sucursal = $empleado->id_sucursal ?? 1;
            } else {
                // Si es cliente web, usar sucursal principal (1)
                $id_sucursal = 1;
            }
        }

        // Obtener inventario DE LA SUCURSAL ESPECÍFICA
        $inventario = Inventario::where('id_detalleproducto', $id_detalleproducto)
                                ->where('id_sucursal', $id_sucursal)
                                ->first();

        if (!$inventario) {
            \Log::warning("Inventario no encontrado para producto: {$id_detalleproducto}, sucursal: {$id_sucursal}");
            return;
        }

        // Verificar si hay suficiente stock
        if ($inventario->stock_actual < $cantidad) {
            \Log::warning("Stock insuficiente en sucursal {$id_sucursal}. Disponible: {$inventario->stock_actual}, Solicitado: {$cantidad}");
            return;
        }

        // Descontar del inventario ESPECÍFICO DE LA SUCURSAL
        $inventario->decrement('stock_actual', $cantidad);
        $inventario->decrement('existencia', $cantidad);

        // Descontar del lote más antiguo (FIFO) DE ESTA SUCURSAL
        $lotes = Lote::where('id_detalleproducto', $id_detalleproducto)
                     ->where('id_sucursal', $id_sucursal)  // ← SOLO DE ESTA SUCURSAL
                     ->where('cantidad_actual', '>', 0)
                     ->orderBy('fechaEntrada', 'asc')
                     ->get();

        $cantidadPorDescontar = $cantidad;

        foreach ($lotes as $lote) {
            if ($cantidadPorDescontar <= 0) break;

            if ($lote->cantidad_actual >= $cantidadPorDescontar) {
                $lote->decrement('cantidad_actual', $cantidadPorDescontar);
                $cantidadPorDescontar = 0;
            } else {
                $cantidadPorDescontar -= $lote->cantidad_actual;
                $lote->update(['cantidad_actual' => 0]);
            }
        }

        \Log::info("Stock descontado correctamente. Producto: {$id_detalleproducto}, Cantidad: {$cantidad}, Sucursal: {$id_sucursal}");

    } catch (\Exception $e) {
        \Log::error("Error al descontar stock: " . $e->getMessage());
    }
}

    /**
     * Mostrar vista de pago
     */
    public function showPago($id)
    {
        $factura = Factura::with('cliente', 'detalles', 'empleado')->findOrFail($id);
        $tiposPago = TipoPago::all();
        $pagosRegistrados = Pago::where('id_factura', $id)->get();
        
        $totalPagado = $pagosRegistrados->sum('monto');
        $faltaPagar = $factura->total - $totalPagado;

        return view('factura.pago', compact('factura', 'tiposPago', 'pagosRegistrados', 'faltaPagar'));
    }

    public function show($id)
    {
        $factura = Factura::with(['cliente', 'detalles.detalleProducto.producto', 'empleadoAnulacion'])->findOrFail($id);
        return view('factura.show', compact('factura'));
    }

    /**
     * Guardar pago (cliente o empleado)
     */
    public function guardarPago(Request $request, $id)
    {
        $request->validate([
            'id_tipo_pago' => 'required|exists:tipopago,id',
            'monto' => 'required|numeric|min:0.01',
            'monto_efectivo' => 'nullable|numeric|min:0.01',
            'no_tarjeta' => 'nullable|string|max:30',
            'no_cheque' => 'nullable|string|max:30',
            'fecha_expiracion' => 'nullable|date',
        ]);

        $factura = Factura::findOrFail($id);
        $tipoPago = TipoPago::find($request->id_tipo_pago);

        //  CALCULAR CAMBIO SI ES EFECTIVO
        $cambio = 0;
        if (strtolower($tipoPago->nombre) === 'efectivo' || strpos(strtolower($tipoPago->nombre), 'efectivo') !== false) {
            $cambio = (float) $request->monto_efectivo - (float) $request->monto;
            if ($cambio < 0) {
                return back()->with('error', 'El monto en efectivo es insuficiente');
            }
        }

        //  GUARDAR PAGO
        Pago::create([
            'id_factura' => $id,
            'monto' => (float) $request->monto,
            'id_tipo_pago' => $request->id_tipo_pago,
            'no_tarjeta' => $request->no_tarjeta ?? null,
            'no_cheque' => $request->no_cheque ?? null,
            'cambio' => $cambio,
            'fecha_expiracion' => $request->fecha_expiracion ?? null,
        ]);

        $totalPagado = Pago::where('id_factura', $id)->sum('monto');
        $faltaPagar = $factura->total - $totalPagado;

        //  SI ESTÁ COMPLETAMENTE PAGADA, CAMBIAR ESTADO
        if ($faltaPagar <= 0) {
            $factura->update(['estado' => 'pagada']);
            session()->forget('carrito');
            return redirect()->route('factura.confirmacion', $id)
                ->with('success', '¡Factura completada!');
        }

        return redirect()->route('factura.showPago', $id)
            ->with('info', "Falta pagar: Q" . number_format($faltaPagar, 2));
    }

    /**
     * Confirmación final
     */
    public function confirmacion($id)
    {
        $factura = Factura::with('cliente', 'detalles', 'pagos', 'empleado')->findOrFail($id);
        return view('factura.confirmacion', compact('factura'));
    }

    /**
     * Generar correlativo único
     */
    private function generarCorrelativo()
    {
        $ultimaFactura = Factura::orderBy('correlativo', 'desc')->first();
        return ($ultimaFactura?->correlativo ?? 0) + 1;
    }
}
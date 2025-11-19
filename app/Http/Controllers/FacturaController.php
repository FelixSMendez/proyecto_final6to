<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Pago;
use App\Models\TipoPago;
use App\Models\UsuarioCliente;
use Illuminate\Http\Request;

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

        // Crear factura SIN empleado (es una venta web)
        $factura = Factura::create([
            'correlativo' => $this->generarCorrelativo(),
            'letra_serie' => 'A',
            'fecha' => now(),
            'id_cliente' => $request->id_cliente,
            'id_empleado' => auth('cliente')->id() ? null : auth('employee')->id(), // ✅ Sin empleado (venta web)
            'id_sucursal' => 1,
            'total' => $total,
        ]);

        // Guardar detalles de factura (items del carrito)
        foreach ($carrito as $id => $item) {
            DetalleFactura::create([
                'id_factura' => $factura->id,
                'id_detalleproducto' => (int) $item['id_detalle'],
                'cantidad' => (int) $item['cantidad'],
                'precio_unitario' => (float) $item['precio'],
                'descuento_aplicado' => 0,
                'subtotal' => (float) $item['precio'] * (int) $item['cantidad'],
            ]);
}

        // Ir a vista de pago
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
            'id_empleado' => auth('employee')->id(), // ✅ Con empleado
            'id_sucursal' => 1,
            'total' => $total,
        ]);

        // Guardar detalles
        foreach ($detalles as $item) {
            DetalleFactura::create([
                'id_factura' => $factura->id,
                'id_detalleproducto' => $item['id_detalle'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'descuento_aplicado' => 0,
            ]);
        }

        return redirect()->route('factura.showPago', $factura->id);
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

        // ✅ CALCULAR CAMBIO SI ES EFECTIVO
        $cambio = 0;
        if (strtolower($tipoPago->nombre) === 'efectivo' || strpos(strtolower($tipoPago->nombre), 'efectivo') !== false) {
            $cambio = (float) $request->monto_efectivo - (float) $request->monto;
            if ($cambio < 0) {
                return back()->with('error', 'El monto en efectivo es insuficiente');
            }
        }

        // ✅ GUARDAR PAGO CON TODOS LOS CAMPOS DE LA TABLA
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

        // ✅ SI ESTÁ COMPLETAMENTE PAGADA, CAMBIAR ESTADO
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
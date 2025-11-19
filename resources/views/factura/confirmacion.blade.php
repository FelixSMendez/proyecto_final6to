@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <div style="font-size: 60px; color: #28a745; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 class="text-success mb-2">¡Compra Completada!</h2>
        <p class="text-muted">Tu factura ha sido procesada exitosamente</p>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📋 Factura #{{ $factura->correlativo }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Número de Serie:</strong> <span class="badge bg-info">{{ $factura->letra_serie }}-{{ str_pad($factura->correlativo, 6, '0', STR_PAD_LEFT) }}</span></p>
                            <p><strong>Cliente:</strong> {{ $factura->cliente->usuario }}</p>
                            <p><strong>Email:</strong> {{ $factura->cliente->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y H:i') }}</p>
                            @if($factura->empleado)
                                <p><strong>Vendedor:</strong> {{ $factura->empleado->usuario }}</p>
                            @else
                                <p><strong>Tipo de Venta:</strong> <span class="badge bg-success">En Línea</span></p>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h6 class="fw-bold mb-3">Productos Comprados:</h6>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio Unit.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalProductos = 0; @endphp
                            @foreach($factura->detalles as $detalle)
                                @php $subtotal = $detalle->precio_unitario * $detalle->cantidad; $totalProductos += $subtotal; @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $detalle->detalleProducto->producto->nombre }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $detalle->detalleProducto->marca->nombre ?? 'N/A' }} - {{ $detalle->detalleProducto->color_acabado ?? 'N/A' }} - {{ $detalle->detalleProducto->tipoMedida->nombre ?? 'N/A' }}</small>
                                    </td>
                                    <td class="text-center"><strong>{{ $detalle->cantidad }}</strong></td>
                                    <td class="text-end">Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="text-end"><strong class="text-primary">Q{{ number_format($subtotal, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="row mb-2">
                                <div class="col-8"><strong>Subtotal:</strong></div>
                                <div class="col-4 text-end">Q{{ number_format($totalProductos, 2) }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-8"><strong>Descuentos:</strong></div>
                                <div class="col-4 text-end">-Q0.00</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-8"><strong>Envío:</strong></div>
                                <div class="col-4 text-end">Q0.00</div>
                            </div>
                            <div class="row bg-light p-3 rounded border-top">
                                <div class="col-8"><h5 class="mb-0">TOTAL PAGADO:</h5></div>
                                <div class="col-4 text-end"><h5 class="mb-0 text-success">Q{{ number_format($factura->total, 2) }}</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">💳 Detalles de Pago</h6>
                </div>
                <div class="card-body">
                    @if($factura->pagos->count() > 0)
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Medio de Pago</th>
                                    <th class="text-center">Referencia</th>
                                    <th class="text-end">Monto</th>
                                    <th class="text-end">Cambio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($factura->pagos as $pago)
                                    <tr>
                                        <td><strong>{{ $pago->tipoPago->nombre }}</strong></td>
                                        <td class="text-center">
                                            @if($pago->no_tarjeta)
                                                <small>{{ str_repeat('*', 12) }}{{ substr($pago->no_tarjeta, -4) }}</small>
                                            @elseif($pago->no_cheque)
                                                <small>{{ $pago->no_cheque }}</small>
                                            @else
                                                <small>-</small>
                                            @endif
                                        </td>
                                        <td class="text-end"><strong>Q{{ number_format($pago->monto, 2) }}</strong></td>
                                        <td class="text-end">
                                            @if($pago->cambio > 0)
                                                <span class="badge bg-warning text-dark">Q{{ number_format($pago->cambio, 2) }}</span>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">Sin registros de pago</p>
                    @endif
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-home me-2"></i> Volver al Catálogo
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('pdf.factura.descargar', $factura->id) }}" class="btn btn-success w-100" target="_blank">
                        <i class="fas fa-download me-2"></i> Descargar Factura
                    </a>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>¡Gracias por tu compra!</strong> Se ha enviado un correo de confirmación a {{ $factura->cliente->email ?? 'tu email registrado' }}.
            </div>

            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">¿Necesitas Ayuda?</h6>
                    <p class="card-text mb-0">Si tienes problemas con tu compra o necesitas soporte, contáctanos en <strong>soporte@tutienda.com</strong> o llama al <strong>+502 XXXX XXXX</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
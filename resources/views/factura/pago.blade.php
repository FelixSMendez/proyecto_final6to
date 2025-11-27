@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📋 Factura #{{ $factura->correlativo }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Cliente:</strong> {{optional($factura->cliente)->getNombre() ?? 'Web'}}</p>
                            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            @if($factura->empleado)
                                <p><strong>Vendedor:</strong> {{ $factura->empleado->usuario }}</p>
                            @else
                                <p><strong>Venta:</strong> Web</p>
                            @endif
                            <p><strong>Serie:</strong> {{ $factura->letra_serie }}-{{ str_pad($factura->correlativo, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    <hr>
                    <h6 class="fw-bold mb-3">Productos:</h6>
                    <table class="table table-sm table-striped">
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
                                        {{ $detalle->detalleProducto->producto->nombre }}
                                        <br>
                                        <small class="text-muted">{{ $detalle->detalleProducto->marca->nombre ?? 'N/A' }} - {{ $detalle->detalleProducto->color_acabado ?? 'N/A' }}</small>
                                    </td>
                                    <td class="text-center">{{ $detalle->cantidad }}</td>
                                    <td class="text-end">Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="text-end"><strong>Q{{ number_format($subtotal, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="row mb-2">
                                <div class="col-6"><strong>Subtotal:</strong></div>
                                <div class="col-6 text-end">Q{{ number_format($totalProductos, 2) }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Envío:</strong></div>
                                <div class="col-6 text-end">Q0.00</div>
                            </div>
                            <div class="row bg-light p-2 rounded">
                                <div class="col-6"><h6 class="mb-0">TOTAL:</h6></div>
                                <div class="col-6 text-end"><h6 class="mb-0 text-primary">Q{{ number_format($factura->total, 2) }}</h6></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">💳 Pagos Realizados</h6>
                </div>
                <div class="card-body">
                    @if($pagosRegistrados->count() > 0)
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Medio</th>
                                    <th class="text-end">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pagosRegistrados as $pago)
                                    <tr>
                                        <td><small>{{ $pago->tipoPago->nombre }}</small></td>
                                        <td class="text-end"><small>Q{{ number_format($pago->monto, 2) }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                    @else
                        <p class="text-muted text-center">Sin pagos aún</p>
                    @endif
                    <div class="mb-3">
                        <div class="row mb-2">
                            <div class="col-6"><small>Total a Pagar:</small></div>
                            <div class="col-6 text-end"><small class="fw-bold">Q{{ number_format($factura->total, 2) }}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><small>Total Pagado:</small></div>
                            <div class="col-6 text-end"><small class="fw-bold">Q{{ number_format($factura->total - $faltaPagar, 2) }}</small></div>
                        </div>
                        <div class="row bg-warning p-2 rounded">
                            <div class="col-6"><small><strong>Falta Pagar:</strong></small></div>
                            <div class="col-6 text-end"><small><strong>Q{{ number_format($faltaPagar, 2) }}</strong></small></div>
                        </div>
                    </div>
                    @if($faltaPagar <= 0)
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>¡Pagado!</strong> Factura completada.
                        </div>
                        <a href="{{ route('factura.confirmacion', $factura->id) }}" class="btn btn-success btn-sm w-100">Ver Comprobante</a>
                    @else
                        <p class="text-muted small mb-3">Ingresa un medio de pago para continuar</p>
                    @endif
                </div>
            </div>
            @if($faltaPagar > 0)
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Agregar Pago</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('factura.guardarPago', $factura->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Medio de Pago</label>
                                <select name="id_tipo_pago" class="form-select" id="tipoPago" required onchange="mostrarCampos()">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($tiposPago as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Monto a Pagar</label>
                                <div class="input-group">
                                    <span class="input-group-text">Q</span>
                                    <input type="number" name="monto" class="form-control" id="montoAPagar" step="0.01" min="0.01" max="{{ $faltaPagar }}" placeholder="0.00" required onchange="calcularCambio()">
                                </div>
                                <small class="text-muted">Máximo: Q{{ number_format($faltaPagar, 2) }}</small>
                            </div>
                            <div class="mb-3" id="campoEfectivo" style="display:none;">
                                <label class="form-label fw-bold">Efectivo Recibido</label>
                                <div class="input-group">
                                    <span class="input-group-text">Q</span>
                                    <input type="number" name="monto_efectivo" class="form-control" id="efectivoRecibido" step="0.01" min="0.01" placeholder="0.00" oninput="calcularCambio()">
                                </div>
                            </div>
                            <div class="mb-3" id="cambioDiv" style="display:none;">
                                <div class="alert alert-success mb-0">
                                    <strong>Cambio:</strong> Q<span id="cambioMonto">0.00</span>
                                </div>
                            </div>
                            <div class="mb-3" id="campotarjeta" style="display:none;">
                                <label class="form-label">No. Tarjeta</label>
                                <input type="text" name="no_tarjeta" class="form-control" placeholder="1234 5678 9012 3456" maxlength="20">
                            </div>
                            <div class="mb-3" id="campocheque" style="display:none;">
                                <label class="form-label">No. Cheque</label>
                                <input type="text" name="no_cheque" class="form-control" placeholder="123456789">
                            </div>
                            <div class="mb-3" id="campofecha" style="display:none;">
                                <label class="form-label">Fecha Expiración</label>
                                <input type="date" name="fecha_expiracion" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-plus me-2"></i> Registrar Pago
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>

function mostrarCampos() {
    const tipoId = document.getElementById('tipoPago').value;
    const tiposPago = @json($tiposPago->pluck('nombre', 'id'));
    
    document.getElementById('campotarjeta').style.display = 'none';
    document.getElementById('campocheque').style.display = 'none';
    document.getElementById('campofecha').style.display = 'none';
    document.getElementById('campoEfectivo').style.display = 'none';
    document.getElementById('cambioDiv').style.display = 'none';

    if (tipoId) {
        
        const tipoNombre = tiposPago[tipoId]?.toLowerCase();
        
        if (tipoNombre && tipoNombre.includes('efectivo')) {
            document.getElementById('campoEfectivo').style.display = 'block';
            document.getElementById('cambioDiv').style.display = 'block';
        } else if (tipoNombre && tipoNombre.includes('tarjeta')) {
            document.getElementById('campotarjeta').style.display = 'block';
            document.getElementById('campofecha').style.display = 'block';
        } else if (tipoNombre && tipoNombre.includes('cheque')) {
            document.getElementById('campocheque').style.display = 'block';
            document.getElementById('campofecha').style.display = 'block';
        }
    }
}

function calcularCambio() {
    const monto = parseFloat(document.getElementById('montoAPagar').value) || 0;
    const efectivo = parseFloat(document.getElementById('efectivoRecibido').value) || 0;
    const cambio = efectivo - monto;
    
    const cambioSpan = document.getElementById('cambioMonto');
    const cambioDiv = document.getElementById('cambioDiv').querySelector('.alert');
    
    if (cambio < 0) {
        cambioSpan.textContent = '0.00';
        cambioDiv.classList.remove('alert-success');
        cambioDiv.classList.add('alert-danger');
        cambioDiv.innerHTML = '<strong>⚠️ Falta:</strong> Q' + Math.abs(cambio).toFixed(2);
    } else {
        cambioSpan.textContent = cambio.toFixed(2);
        cambioDiv.classList.remove('alert-danger');
        cambioDiv.classList.add('alert-success');
        cambioDiv.innerHTML = '<strong>Cambio:</strong> Q' + cambio.toFixed(2);
    }
}
</script>

@endsection
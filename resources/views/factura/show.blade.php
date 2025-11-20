@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Factura #{{ $factura->id }}</h1>
        <a href="{{ route('factura.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- INFORMACIÓN GENERAL -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Información General</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> {{ $factura->cliente->usuario ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $factura->cliente->email ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $factura->cliente->telefono ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha:</strong> {{ $factura->fecha->format('d/m/Y') }}</p>
                    <p><strong>Estado:</strong> 
                        @if($factura->estado === 'anulada')
                            <span class="badge bg-danger">ANULADA</span>
                        @elseif($factura->estado === 'pagada')
                            <span class="badge bg-success">PAGADA</span>
                        @elseif($factura->estado === 'cancelada')
                            <span class="badge bg-warning">CANCELADA</span>
                        @else
                            <span class="badge bg-info">{{ ucfirst($factura->estado) }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- DETALLES DE PRODUCTOS -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Detalles de la Factura</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($factura->detalles as $detalle)
                        <tr>
                            <td>
                                <strong>{{ $detalle->detalleProducto->producto->nombre ?? 'Producto' }}</strong>
                            </td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>Q {{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>Q {{ number_format($detalle->descuento_aplicado ?? 0, 2) }}</td>
                            <td><strong>Q {{ number_format($detalle->subtotal, 2) }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Sin productos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TOTAL -->
    <div class="card mb-4">
        <div class="card-body text-right">
            <h3>Total: <span class="text-primary">Q {{ number_format($factura->total, 2) }}</span></h3>
        </div>
    </div>

    <!-- INFORMACIÓN DE ANULACIÓN (si aplica) -->
    @if($factura->estado === 'anulada')
    <div class="alert alert-danger">
        <h5><i class="fas fa-ban"></i> Factura Anulada</h5>
        <p><strong>Razón:</strong> {{ $factura->razon_anulacion }}</p>
        <p><strong>Fecha de Anulación:</strong> {{ $factura->fecha_anulacion->format('d/m/Y H:i') }}</p>
        <p><strong>Anulado por:</strong> {{ $factura->empleadoAnulacion->usuario ?? 'Sistema' }}</p>
    </div>
    @endif

    <!-- BOTONES DE ACCIÓN -->
    <div class="mb-4">
        <a href="{{ route('factura.descargarPDF', $factura->id) }}" class="btn btn-primary">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>

        {{-- BOTÓN ANULAR: Solo para gerente y si NO está anulada --}}
        @if(auth('employee')->check() && auth('employee')->user()->rol === 'gerente')
            @if($factura->estado !== 'anulada')
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#anularModal">
                    <i class="fas fa-ban"></i> Anular Factura
                </button>
            @endif
        @endif
    </div>
</div>

<!-- MODAL DE ANULACIÓN -->
<div class="modal fade" id="anularModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Anular Factura #{{ $factura->id }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('factura.anular', $factura->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>⚠️ Advertencia:</strong> Esta acción es irreversible. La factura se marcará como anulada.
                    </div>
                    <div class="mb-3">
                        <label for="razon" class="form-label">Razón de Anulación:</label>
                        <textarea 
                            class="form-control @error('razon_anulacion') is-invalid @enderror" 
                            id="razon" 
                            name="razon_anulacion" 
                            rows="4" 
                            placeholder="Ej: Error en datos del cliente, producto defectuoso, cambio de pedido..." 
                            required>
                        </textarea>
                        @error('razon_anulacion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-check"></i> Confirmar Anulación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
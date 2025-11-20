@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Anular Factura #{{ $factura->id }}</h1>
        <a href="{{ route('gerente.facturas-anular') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- INFORMACIÓN FACTURA -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Información de la Factura</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> {{ $factura->cliente->usuario }}</p>
                    <p><strong>Email:</strong> {{ $factura->cliente->email }}</p>
                    <p><strong>Fecha:</strong> {{ $factura->fecha->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Vendedor:</strong> {{ $factura->empleado->usuario ?? 'N/A' }}</p>
                    <p><strong>Total:</strong> <strong class="text-success">Q {{ number_format($factura->total, 2) }}</strong></p>
                    <p><strong>Estado:</strong> <span class="badge bg-info">{{ ucfirst($factura->estado) }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- DETALLES PRODUCTOS -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Detalles</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>P. Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->detalleProducto->producto->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>Q {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>Q {{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- FORMULARIO ANULACIÓN -->
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Anular Factura</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('gerente.factura-anular-guardar', $factura->id) }}">
                @csrf
                
                <div class="alert alert-warning">
                    <strong>⚠️ Advertencia:</strong> Esta acción es <strong>irreversible</strong>. 
                    La factura se marcará como anulada y no se contabilizará en reportes financieros.
                </div>

                <div class="mb-3">
                    <label for="razon" class="form-label"><strong>Razón de Anulación:</strong></label>
                    <textarea 
                        class="form-control @error('razon_anulacion') is-invalid @enderror" 
                        id="razon" 
                        name="razon_anulacion" 
                        rows="5" 
                        placeholder="Describe detalladamente la razón de anulación..."
                        required>
                    </textarea>
                    @error('razon_anulacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-check"></i> Confirmar Anulación
                    </button>
                    <a href="{{ route('gerente.facturas-anular') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
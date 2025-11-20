@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-search me-2"></i> Reporte 7: Búsqueda de Factura</h1>
        <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-info text-white"><h5 class="mb-0">Buscar por Número de Factura</h5></div>
        <div class="card-body">
            <form method="GET" class="d-flex gap-2">
                <input type="number" name="numero" class="form-control" placeholder="Número de factura" required>
                <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Buscar</button>
            </form>
        </div>
    </div>

    @if(request()->has('numero') && request()->numero)
        @if($factura)
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Factura #{{ $factura['id_factura'] ?? $factura['numero'] }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Cliente:</strong> {{ $factura['cliente']['usuario'] ?? $factura['cliente']['nombre'] ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $factura['cliente']['email'] ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Fecha:</strong> {{ $factura['fecha'] ?? $factura['created_at'] ?? 'N/A' }}</p>
                        <p><strong>Total:</strong> <span class="badge bg-success">Q {{ number_format($factura['total'] ?? 0, 2) }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detalles --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white"><h5 class="mb-0">Productos</h5></div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-end">Cantidad</th>
                            <th class="text-end">P. Unitario</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($factura['detalles'] ?? [] as $detalle)
                        <tr>
                            <td>{{ $detalle->detalleProducto->producto->nombre ?? 'N/A' }}</td>
                            <td class="text-end">{{ $detalle['cantidad'] }}</td>
                            <td class="text-end">Q {{ number_format($detalle['precio_unitario'] ?? 0, 2) }}</td>
                            <td class="text-end">Q {{ number_format($detalle['subtotal'] ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">Sin productos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagos --}}
        <div class="card">
            <div class="card-header bg-info text-white"><h5 class="mb-0">Medios de Pago</h5></div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo</th>
                            <th class="text-end">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($factura['pagos'] ?? [] as $pago)
                        <tr>
                            <td>
                                {{ $pago['tipo_pago']['nombre'] ?? $pago['tipoPago']['nombre'] ?? 'N/A' }}
                            </td>
                            <td class="text-end">Q {{ number_format($pago['monto'] ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center">Sin pagos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Factura no encontrada</div>
        @endif
    @endif
</div>
@endsection
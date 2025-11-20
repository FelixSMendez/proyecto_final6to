@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-ban"></i> Anular Facturas</h1>
        <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>

    @if($facturas->count())
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Factura</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facturas as $factura)
                <tr>
                    <td><strong>#{{ $factura->id }}</strong></td>
                    <td>{{ $factura->cliente->nombre ?? 'N/A' }}</td>
                    <td>{{ $factura->fecha->format('d/m/Y') }}</td>
                    <td>Q {{ number_format($factura->total, 2) }}</td>
                    <td>
                        @if($factura->estado === 'anulada')
                            <span class="badge bg-danger">ANULADA</span>
                        @elseif($factura->estado === 'pagada')
                            <span class="badge bg-success">PAGADA</span>
                        @else
                            <span class="badge bg-info">{{ ucfirst($factura->estado) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($factura->estado !== 'anulada')
                            <a href="{{ route('gerente.factura-anular-detalle', $factura->id) }}" 
                               class="btn btn-sm btn-danger">
                                <i class="fas fa-ban"></i> Anular
                            </a>
                        @else
                            <span class="badge bg-secondary">Anulada</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- PAGINACIÓN -->
    <div class="d-flex justify-content-center mt-4">
        {{ $facturas->links() }}
    </div>
    @else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No hay facturas disponibles para anular.
    </div>
    @endif
</div>
@endsection
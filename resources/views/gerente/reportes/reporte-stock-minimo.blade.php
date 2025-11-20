@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-bell me-2"></i> Reporte 9: Stock Bajo Mínimo</h1>
        <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card">
        <div class="card-header bg-warning text-dark"><h5 class="mb-0">Productos que Necesitan Reabastecimiento</h5></div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Sucursal</th>
                        <th class="text-center">Stock Actual</th>
                        <th class="text-center">Mínimo</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alertas as $alerta)
                    <tr>
                        <td><strong>{{ $alerta['producto'] }}</strong></td>
                        <td>{{ $alerta['sucursal'] }}</td>
                        <td class="text-center">
                            <span class="badge bg-danger">{{ $alerta['stock_actual'] }}</span>
                        </td>
                        <td class="text-center">{{ $alerta['stock_minimo'] }}</td>
                        <td class="text-center">
                            <span class="badge bg-warning">Reorden urgente</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-success">✅ Todos los productos están sobre el mínimo</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

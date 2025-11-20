@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-warehouse me-2"></i> Reporte 4: Inventario General</h1>
        <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white"><h5 class="mb-0">Stock Actual Todos los Productos</h5></div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Stock Total</th>
                        <th>Unidad</th>
                        <th>Stock Mínimo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventario as $item)
                    <tr>
                        <td><strong>{{ $item['producto'] }}</strong></td>
                        <td class="text-center"><span class="badge bg-success">{{ $item['stock_actual'] }}</span></td>
                        <td>{{ $item['unidad'] }}</td>
                        <td class="text-center">
                            <span class="badge bg-warning">{{ $item['stock_minimo'] }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">Sin datos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
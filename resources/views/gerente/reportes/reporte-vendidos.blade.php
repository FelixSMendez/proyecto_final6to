@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-shopping-cart me-2"></i> Reporte 3: Productos Más Vendidos</h1>
        <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-info text-white"><h5 class="mb-0">Seleccionar Rango de Fechas</h5></div>
        <div class="card-body">
            <form method="GET" class="d-flex gap-2 align-items-end">
                <div class="flex-grow-1">
                    <label class="form-label">Fecha Inicio:</label>
                    <input 
                        type="date" 
                        name="fecha_inicio" 
                        class="form-control"
                        value="{{ request('fecha_inicio', now()->format('Y-m-d')) }}"
                    >
                </div>
                <div class="flex-grow-1">
                    <label class="form-label">Fecha Fin:</label>
                    <input 
                        type="date" 
                        name="fecha_fin" 
                        class="form-control"
                        value="{{ request('fecha_fin', now()->format('Y-m-d')) }}"
                    >
                </div>
                <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Generar</button>
            </form>
        </div>
    </div>

    @if(request()->has('fecha_inicio'))
        <div class="card">
            <div class="card-header bg-primary text-white"><h5 class="mb-0">Top Productos por Cantidad Vendida</h5></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th class="text-end">Cantidad Vendida</th>
                            <th class="text-end">Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = collect($data)->sum('cantidad'); @endphp
                        @forelse($data as $i => $item)
                        <tr>
                            <td><strong>{{ $i + 1 }}</strong></td>
                            <td>{{ $item['producto'] }}</td>
                            <td class="text-end">{{ $item['cantidad'] }}</td>
                            <td class="text-end">
                                <span class="badge bg-info">
                                    {{ $total > 0 ? round(($item['cantidad'] / $total) * 100, 2) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Sin datos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
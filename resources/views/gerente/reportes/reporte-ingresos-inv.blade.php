@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-clipboard-list me-2"></i> Reporte 8: Ingresos a Inventario</h1>
        <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-info text-white"><h5 class="mb-0">Filtrar por Fechas</h5></div>
        <div class="card-body">
            <form method="GET" class="row g-3 d-flex align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" name="fecha_inicio" value="{{ request('fecha_inicio', now()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" name="fecha_fin" value="{{ request('fecha_fin', now()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-info w-100">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white"><h5 class="mb-0">Ingresos de Producto al Inventario</h5></div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Proveedor</th>
                        <th>Sucursal</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-end">Lote Cargado</th>
                        <th class="text-end">Stock Actual Lote</th>
                        <th class="text-end">Costo Unidad</th>
                        <th class="text-end">Total Costo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $item['producto'] }}</td>
                        <td>{{ $item['proveedor'] }}</td>
                        <td>{{ $item['sucursal'] }}</td>
                        <td class="text-center">{{ $item['fecha_entrada'] }}</td>
                        <td class="text-end">{{ $item['cantidad'] }}</td>
                        <td class="text-end">{{ $item['cantidad_actual'] }}</td>
                        <td class="text-end">Q {{ number_format($item['costo_unitario'], 2) }}</td>
                        <td class="text-end">Q {{ number_format($item['total_costo'], 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Sin ingresos en el rango seleccionado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
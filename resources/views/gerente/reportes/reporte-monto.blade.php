@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>
                <i class="fas fa-chart-bar me-2"></i>Reporte 1: Total Facturado por Tipo de Pago
            </h1>
            <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    {{-- Filtro de fechas --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Seleccionar Rango de Fechas</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
    <div class="col-md-5">
        <label class="form-label">Fecha Inicio:</label>
        <input 
            type="date" 
            name="fecha_inicio" 
            class="form-control" 
            value="{{ request('fecha_inicio', now()->format('Y-m-d')) }}"
        >
    </div>
    <div class="col-md-5">
        <label class="form-label">Fecha Fin:</label>
        <input 
            type="date" 
            name="fecha_fin" 
            class="form-control" 
            value="{{ request('fecha_fin', now()->format('Y-m-d')) }}"
        >
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-search"></i> Generar
        </button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de resultados --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Totales por Medio de Pago</h5>
                </div>
                <div class="card-body">
                    @if($data && count($data) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Medio de Pago</th>
                                        <th class="text-end">Total (Q)</th>
                                        <th class="text-end">Cantidad de Pagos</th>
                                        <th class="text-end">Promedio (Q)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $item['medio'] }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <strong>Q {{ number_format($item['total'], 2, '.', ',') }}</strong>
                                            </td>
                                            <td class="text-end">
                                                {{ $item['cantidad'] }}
                                            </td>
                                            <td class="text-end">
                                                Q {{ number_format($item['total'] / $item['cantidad'], 2, '.', ',') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="2"><strong>TOTAL GENERAL</strong></td>
                                        <td class="text-end">
                                            <strong>Q {{ number_format(collect($data)->sum('total'), 2, '.', ',') }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ collect($data)->sum('cantidad') }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <strong>Q {{ number_format(collect($data)->sum('total') / collect($data)->sum('cantidad'), 2, '.', ',') }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Sin datos</strong> para el rango de fechas seleccionado.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts para fecha picker --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Si quieres agregar un date picker, puedes usar flatpickr o similar
        // Por ahora funciona con input text
    });
</script>
@endsection
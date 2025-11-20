@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h1><i class="fas fa-arrow-down"></i> Reporte 9: Ingresos a Inventario</h1>
|   <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    <div class="card mb-4">
        <div class="card-header bg-success">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <label>Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control" 
                           value="{{ $fecha_inicio }}">
                </div>
                <div class="col-md-4">
                    <label>Fecha Fin</label>
                    <input type="date" name="fecha_fin" class="form-control" 
                           value="{{ $fecha_fin }}">
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-success w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Sucursal</th>
                    <th class="text-end">Cantidad</th>
                    <th class="text-center">Fecha Entrada</th>
                    <th class="text-end">Costo Unit.</th>
                    <th class="text-end">Total Costo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $item['producto'] }}</td>
                    <td>{{ $item['proveedor'] }}</td>
                    <td>{{ $item['sucursal'] }}</td>
                    <td class="text-end">{{ $item['cantidad'] }}</td>
                    <td class="text-center">{{ $item['fecha_entrada'] }}</td>
                    <td class="text-end">Q {{ number_format($item['costo_unitario'], 2) }}</td>
                    <td class="text-end"><strong>Q {{ number_format($item['total_costo'], 2) }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Sin ingresos en el rango seleccionado</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
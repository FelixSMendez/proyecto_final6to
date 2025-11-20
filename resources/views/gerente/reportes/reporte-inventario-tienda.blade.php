@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h1><i class="fas fa-warehouse"></i> Reporte 8: Inventario por Sucursal</h1>
    <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    <div class="card mb-4">
        <div class="card-header bg-info">
            <form method="GET" class="row g-2">
                <div class="col-md-6">
                    <select name="id_sucursal" class="form-control">
                        <option value="">-- Todas las sucursales --</option>
                        @foreach($sucursales as $suc)
                            <option value="{{ $suc->id }}" {{ $sucursal_id == $suc->id ? 'selected' : '' }}>
                                {{ $suc->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-info">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Sucursal</th>
                    <th class="text-end">Stock Actual</th>
                    <th class="text-end">Stock Mínimo</th>
                    <th class="text-end">Stock Máximo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $item['producto'] }}</td>
                    <td>{{ $item['sucursal'] }}</td>
                    <td class="text-end">{{ $item['existencia'] }}</td>
                    <td class="text-end">{{ $item['stock_minimo'] }}</td>
                    <td class="text-end">{{ $item['stock_maximo'] }}</td>
                    <td>
                        @if($item['estado'] === 'Bajo')
                            <span class="badge bg-danger">Bajo Stock</span>
                        @else
                            <span class="badge bg-success">Normal</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Sin registros</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
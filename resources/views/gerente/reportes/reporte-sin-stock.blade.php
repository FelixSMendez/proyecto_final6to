@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-exclamation-triangle me-2"></i> Reporte 7: Productos Sin Stock</h1>
        <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card">
        <div class="card-header bg-danger text-white"><h5 class="mb-0">Productos Agotados - Requieren Reorden</h5></div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Sucursal</th>
                        <th class="text-center">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $item)
                    <tr>
                        <td><strong>{{ $item['producto'] }}</strong></td>
                        <td>{{ $item['sucursal'] }}</td>
                        <td class="text-center"><span class="badge bg-danger">{{ $item['stock_actual'] }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-success">✅ Todos los productos tienen stock</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
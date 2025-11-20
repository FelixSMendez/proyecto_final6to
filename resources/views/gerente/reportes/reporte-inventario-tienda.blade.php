@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-store me-2"></i> Reporte 10: Inventario por Tienda</h1>
        <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
    </div>

    @php
        $sucursales = App\Models\Sucursal::all();
    @endphp

    <div class="row mb-4">
        @forelse($sucursales as $tienda)
        <div class="col-md-6 mb-3">
            <a href="?tienda_id={{ $tienda->id }}" class="card text-decoration-none h-100 {{ request('tienda_id') == $tienda->id ? 'border-primary border-3' : '' }}">
                <div class="card-body text-center">
                    <h5>{{ $tienda->nombre }}</h5>
                    <p class="text-muted">{{ $tienda->direccion ?? 'Sin dirección' }}</p>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Sin sucursales registradas</div>
        </div>
        @endforelse
    </div>

    @if(request()->has('tienda_id'))
        @php
            $response = (new App\Http\Controllers\ReportController)->inventarioPorTienda(request('tienda_id'));
            $data = json_decode($response->content(), true);
        @endphp

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Inventario - Total Valor: Q {{ number_format($data['total_valor'] ?? 0, 2) }}</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">P. Unitario</th>
                            <th class="text-end">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['inventario'] ?? [] as $item)
                        <tr>
                            <td>{{ $item['producto'] }}</td>
                            <td class="text-center">{{ $item['cantidad'] }}</td>
                            <td class="text-end">Q {{ number_format($item['precio_unitario'], 2) }}</td>
                            <td class="text-end"><strong>Q {{ number_format($item['valor_total'], 2) }}</strong></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Sin productos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
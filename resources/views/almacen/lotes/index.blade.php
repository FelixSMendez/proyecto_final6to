@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-list me-2"></i> Lotes de Inventario
            </h1>
            <a href="{{ route('dashboard.digitador') }}" class="btn btn-secondary">Volver</a>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('almacen.lotes.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Lote
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Código Lote</th>
                        <th>Producto</th>
                        <th>Sucursal</th>
                        <th>Proveedor</th>
                        <th class="text-end">Cantidad</th>
                        <th class="text-end">Costo Unit.</th>
                        <th>Fecha Entrada</th>
                        <th>Caducidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lotes as $lote)
                    <tr>
                        <td><strong>{{ $lote->codLote }}</strong></td>
                        <td>{{ $lote->detalleProducto->producto->nombre }}</td>
                        <td>{{ $lote->sucursal->nombre }}</td>
                        <td>{{ $lote->proveedor->nombre }}</td>
                        <td class="text-end">{{ $lote->cantidad }}</td>
                        <td class="text-end">Q {{ number_format($lote->costoUnidad, 2) }}</td>
                        <td>{{ $lote->fechaEntrada->format('d/m/Y') }}</td>
                        <td>
                            @if($lote->fechaCaducidad < now())
                                <span class="badge bg-danger">Vencido</span>
                            @else
                                {{ $lote->fechaCaducidad->format('d/m/Y') }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('almacen.lotes.show', $lote->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Sin lotes registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $lotes->links() }}
    </div>
</div>
@endsection
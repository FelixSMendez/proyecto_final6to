@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-palette me-2"></i>Detalles de Productos</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('detalleproductos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nuevo Detalle
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Marca</th>
                        <th>Medida</th>
                        <th>Color/Acabado</th>
                        <th>Descripción</th>
                        <th style="width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detalles as $detalle)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $detalle->id }}</span></td>
                            <td><strong>{{ $detalle->producto->nombre ?? 'N/A' }}</strong></td>
                            <td>{{ $detalle->marca->marca ?? 'N/A' }}</td>
                            <td>{{ $detalle->tipoMedida->tipo ?? 'N/A' }}</td>
                            <td>
                                <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $detalle->color_acabado ?? '#ccc' }}; border: 1px solid #999; border-radius: 3px;" title="{{ $detalle->color_acabado }}"></span>
                                {{ $detalle->color_acabado }}
                            </td>
                            <td>{{ Str::limit($detalle->descripcion, 30) }}</td>
                            <td>
                                <a href="{{ route('detalleproductos.edit', $detalle->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <form action="{{ route('detalleproductos.destroy', $detalle->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                                        <i class="fas fa-trash me-1"></i>Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox me-2"></i>No hay detalles de productos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($detalles->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $detalles->links() }}
        </div>
    @endif
</div>
@endsection
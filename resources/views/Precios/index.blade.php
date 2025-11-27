@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-tag me-2"></i>Gestión de Precios</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('precios.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nuevo Precio
            </a>
            <a href="{{ route('dashboard.digitador') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Marca</th>
                        <th>Medida</th>
                        <th>Tipo Cliente</th>
                        <th>Cantidad Mín - Máx</th>
                        <th>Precio Venta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($precios as $precio)
                        <tr>
                            <td><strong>#{{ $precio->id }}</strong></td>
                            <td>{{ $precio->detalleProducto->producto->nombre ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $precio->detalleProducto->marca->marca ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $precio->detalleProducto->tipoMedida->nombre ?? 'N/A' }}</td>
                            <td>
                                @if($precio->tipo_cliente == 'minorista')
                                    <span class="badge bg-success">Minorista</span>
                                @elseif($precio->tipo_cliente == 'mayorista')
                                    <span class="badge bg-warning">Mayorista</span>
                                @else
                                    <span class="badge bg-danger">Distribuidor</span>
                                @endif
                            </td>
                            <td>
                                {{ $precio->cantidadminima ?? '∞' }} - {{ $precio->cantidadmaxima ?? '∞' }}
                            </td>
                            <td>
                                <strong class="text-primary">Q{{ number_format($precio->precioVenta, 2) }}</strong>
                            </td>
                            <td>
                                <a href="{{ route('precios.edit', $precio->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('precios.destroy', $precio->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar precio?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p>No hay precios registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $precios->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
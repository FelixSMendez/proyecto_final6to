@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-credit-card me-2"></i>Tipos de Pago</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tipopagos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nuevo Tipo
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
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th style="width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tipopagos as $tipo)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $tipo->id }}</span></td>
                            <td><strong>{{ $tipo->nombre }}</strong></td>
                            <td>{{ Str::limit($tipo->descripcion, 50) }}</td>
                            <td>
                                <a href="{{ route('tipopagos.edit', $tipo->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <form action="{{ route('tipopagos.destroy', $tipo->id) }}" method="POST" style="display:inline;">
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
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox me-2"></i>No hay tipos de pago registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($tipopagos->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $tipopagos->links() }}
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-store me-2"></i>Sucursales</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('sucursales.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nueva Sucursal
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
                        <th>Ciudad</th>
                        <th>Dirección</th>
                        <th style="width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sucursales as $sucursal)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $sucursal->id }}</span></td>
                            <td><strong>{{ $sucursal->nombre }}</strong></td>
                            <td>{{ $sucursal->ciudad }}</td>
                            <td>{{ Str::limit($sucursal->dirección, 40) }}</td>
                            <td>
                                <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <form action="{{ route('sucursales.destroy', $sucursal->id) }}" method="POST" style="display:inline;">
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
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox me-2"></i>No hay sucursales registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($sucursales->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $sucursales->links() }}
        </div>
    @endif
</div>
@endsection
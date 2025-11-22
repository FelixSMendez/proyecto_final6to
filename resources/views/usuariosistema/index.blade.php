@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-tie me-2"></i> Usuarios del Sistema
            </h1>
            <p class="text-muted small">Gestión de empleados y acceso al sistema</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('usuariosistema.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if($usuarios->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 150px;">Empleado</th>
                                    <th style="width: 150px;">Usuario</th>
                                    <th style="width: 150px;">Rol</th>
                                    <th style="width: 150px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuarios as $usuario)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $usuario->empleado ? $usuario->empleado->nombre : 'Sin asignar' }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $usuario->usuario }}</strong></td>
                                    <td>
                                        <span class="badge bg-info">{{ $usuario->getTipoRolAttribute() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('usuariosistema.edit', $usuario->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </a>
                                        <form method="POST" action="{{ route('usuariosistema.destroy', $usuario->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este usuario?')">
                                                <i class="fas fa-trash me-1"></i>Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $usuarios->links() }}
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> No hay usuarios registrados
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
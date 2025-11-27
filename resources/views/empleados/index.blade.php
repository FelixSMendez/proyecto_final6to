@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-users me-2"></i> Empleados
            </h1>
            <p class="text-muted small">Gestión de empleados y datos personales</p>
            <a href="{{ route('gerente.dashboard') }}" class="btn btn-secondary">Volver</a>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('empleados.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nuevo Empleado
            </a>
        </div>
    </div>

    <!-- Tabla de Empleados -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if($empleados->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 180px;">Nombre Completo</th>
                                    <th style="width: 150px;">Email</th>
                                    <th style="width: 120px;">Rol</th>
                                    <th style="width: 150px;">Sucursal</th>
                                    <th style="width: 150px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empleados as $empleado)
                                <tr>
                                    <td>
                                        <strong>{{ $empleado->nombre }} {{ $empleado->apellido }}</strong>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $empleado->email }}">{{ $empleado->email }}</a>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $empleado->rol ? $empleado->rol->tipo : 'Sin rol' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $empleado->sucursal ? $empleado->sucursal->nombre : 'Sin sucursal' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </a>
                                        <form method="POST" action="{{ route('empleados.destroy', $empleado->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este empleado?')">
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
                        {{ $empleados->links() }}
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> No hay empleados registrados
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
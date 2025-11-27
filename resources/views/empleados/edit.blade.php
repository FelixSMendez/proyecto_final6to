@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-edit me-2"></i> Editar Empleado
            </h1>
            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('empleados.update', $empleado->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="form-group mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input 
                                type="text" 
                                class="form-control @error('nombre') is-invalid @enderror" 
                                id="nombre" 
                                name="nombre" 
                                value="{{ old('nombre', $empleado->nombre) }}"
                                placeholder="Ingrese el nombre"
                                required
                            >
                            @error('nombre')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Apellido -->
                        <div class="form-group mb-3">
                            <label for="apellido" class="form-label">Apellido *</label>
                            <input 
                                type="text" 
                                class="form-control @error('apellido') is-invalid @enderror" 
                                id="apellido" 
                                name="apellido" 
                                value="{{ old('apellido', $empleado->apellido) }}"
                                placeholder="Ingrese el apellido"
                                required
                            >
                            @error('apellido')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $empleado->email) }}"
                                placeholder="ejemplo@correo.com"
                                required
                            >
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div class="form-group mb-3">
                            <label for="id_rol" class="form-label">Rol *</label>
                            <select 
                                class="form-control @error('id_rol') is-invalid @enderror" 
                                id="id_rol" 
                                name="id_rol"
                                required
                            >
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('id_rol', $empleado->id_rol) == $rol->id ? 'selected' : '' }}>
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_rol')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sucursal -->
                        <div class="form-group mb-3">
                            <label for="id_sucursal" class="form-label">Sucursal *</label>
                            <select 
                                class="form-control @error('id_sucursal') is-invalid @enderror" 
                                id="id_sucursal" 
                                name="id_sucursal"
                                required
                            >
                                <option value="">Seleccione una sucursal</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}" {{ old('id_sucursal', $empleado->id_sucursal) == $sucursal->id ? 'selected' : '' }}>
                                        {{ $sucursal->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_sucursal')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Actualizar Empleado
                            </button>
                            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
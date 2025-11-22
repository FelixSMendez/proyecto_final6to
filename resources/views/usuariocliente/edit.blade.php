@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Usuario de Cliente</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('usuariocliente.update', $usuariocliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario *</label>
                            <input type="text" class="form-control @error('usuario') is-invalid @enderror" id="usuario" name="usuario" value="{{ old('usuario', $usuariocliente->usuario) }}" required maxlength="50">
                            @error('usuario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('contrasena') is-invalid @enderror" id="contrasena" name="contrasena" maxlength="200" placeholder="Dejar en blanco si no deseas cambiarla">
                            <small class="form-text text-muted">Dejar en blanco para mantener la contraseña actual</small>
                            @error('contrasena')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror" id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico', $usuariocliente->correo_electronico) }}" required maxlength="100">
                            @error('correo_electronico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_cliente" class="form-label">Cliente *</label>
                            <select class="form-select @error('id_cliente') is-invalid @enderror" id="id_cliente" name="id_cliente" required>
                                <option value="">-- Selecciona un cliente --</option>
                                @if(isset($clientes))
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('id_cliente', $usuariocliente->id_cliente) == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('id_cliente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                            <a href="{{ route('usuariocliente.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
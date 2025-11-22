@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Proveedor</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required maxlength="100">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contacto" class="form-label">Contacto *</label>
                            <input type="text" class="form-control @error('contacto') is-invalid @enderror" id="contacto" name="contacto" value="{{ old('contacto', $proveedor->contacto) }}" required maxlength="100">
                            @error('contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dirección" class="form-label">Dirección *</label>
                            <input type="text" class="form-control @error('dirección') is-invalid @enderror" id="dirección" name="dirección" value="{{ old('dirección', $proveedor->dirección) }}" required maxlength="150">
                            @error('dirección')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}" required maxlength="20">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                            <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
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
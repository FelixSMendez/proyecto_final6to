@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Crear Nuevo Producto</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_tipoProducto" class="form-label">Tipo de Producto *</label>
                            <select class="form-select @error('id_tipoProducto') is-invalid @enderror" id="id_tipoProducto" name="id_tipoProducto" required>
                                <option value="">-- Selecciona un tipo --</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('id_tipoProducto') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->tipo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_tipoProducto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Guardar
                            </button>
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
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
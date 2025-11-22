@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Tipo de Medida</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tipomedidas.update', $tipomedida->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <input type="text" class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ old('tipo', $tipomedida->tipo) }}" required maxlength="50" placeholder="Ej: 1/32, 1/16, 1/8, etc">
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" maxlength="200">{{ old('descripcion', $tipomedida->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                            <a href="{{ route('tipomedidas.index') }}" class="btn btn-secondary">
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
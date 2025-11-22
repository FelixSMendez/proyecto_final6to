@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Detalle de Producto</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('detalleproductos.update', $detalleproducto->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_producto" class="form-label">Producto *</label>
                            <select class="form-select @error('id_producto') is-invalid @enderror" id="id_producto" name="id_producto" required>
                                <option value="">-- Selecciona un producto --</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" {{ old('id_producto', $detalleproducto->id_producto) == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_marca" class="form-label">Marca *</label>
                            <select class="form-select @error('id_marca') is-invalid @enderror" id="id_marca" name="id_marca" required>
                                <option value="">-- Selecciona una marca --</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id }}" {{ old('id_marca', $detalleproducto->id_marca) == $marca->id ? 'selected' : '' }}>
                                        {{ $marca->marca }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_tipoMedida" class="form-label">Tipo de Medida *</label>
                            <select class="form-select @error('id_tipoMedida') is-invalid @enderror" id="id_tipoMedida" name="id_tipoMedida" required>
                                <option value="">-- Selecciona una medida --</option>
                                @foreach($medidas as $medida)
                                    <option value="{{ $medida->id }}" {{ old('id_tipoMedida', $detalleproducto->id_tipoMedida) == $medida->id ? 'selected' : '' }}>
                                        {{ $medida->tipo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_tipoMedida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="color_acabado" class="form-label">Color/Acabado *</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('color_acabado') is-invalid @enderror" id="color_acabado" name="color_acabado" value="{{ old('color_acabado', $detalleproducto->color_acabado) }}" required maxlength="100" placeholder="Ej: Rojo brillante">
                                <input type="color" class="form-control form-control-color" id="color_picker" value="{{ old('color_acabado', $detalleproducto->color_acabado) ?? '#000000' }}" style="width: 60px; cursor: pointer;">
                            </div>
                            @error('color_acabado')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" maxlength="200">{{ old('descripcion', $detalleproducto->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                            <a href="{{ route('detalleproductos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sincronizar color picker con input de texto
    document.getElementById('color_picker').addEventListener('input', function() {
        document.getElementById('color_acabado').value = this.value;
    });
</script>
@endsection
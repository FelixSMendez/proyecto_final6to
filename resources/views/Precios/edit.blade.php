@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Precio</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('precios.update', $precio->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_detalleproducto" class="form-label">Producto *</label>
                            <select class="form-select @error('id_detalleproducto') is-invalid @enderror" 
                                    id="id_detalleproducto" name="id_detalleproducto" required>
                                <option value="">-- Selecciona un producto --</option>
                                @foreach($detallesProductos as $detalle)
                                    <option value="{{ $detalle->id }}" {{ old('id_detalleproducto', $precio->id_detalleproducto) == $detalle->id ? 'selected' : '' }}>
                                        {{ $detalle->producto->nombre }} - {{ $detalle->marca->marca ?? 'N/A' }} ({{ $detalle->tipoMedida->nombre ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_detalleproducto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" 
                                   value="{{ old('tipo', $precio->tipo) }}" maxlength="50" placeholder="Ej: Normal, Promoción">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cantidadminima" class="form-label">Cantidad Mínima</label>
                                <input type="number" class="form-control" id="cantidadminima" name="cantidadminima" 
                                       value="{{ old('cantidadminima', $precio->cantidadminima) }}" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cantidadmaxima" class="form-label">Cantidad Máxima</label>
                                <input type="number" class="form-control @error('cantidadmaxima') is-invalid @enderror" 
                                       id="cantidadmaxima" name="cantidadmaxima" 
                                       value="{{ old('cantidadmaxima', $precio->cantidadmaxima) }}" min="0">
                                @error('cantidadmaxima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="precioVenta" class="form-label">Precio Venta (Q) *</label>
                            <input type="number" class="form-control @error('precioVenta') is-invalid @enderror" 
                                   id="precioVenta" name="precioVenta" value="{{ old('precioVenta', $precio->precioVenta) }}" 
                                   step="0.01" min="0" required>
                            @error('precioVenta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo_cliente" class="form-label">Tipo de Cliente *</label>
                            <select class="form-select @error('tipo_cliente') is-invalid @enderror" 
                                    id="tipo_cliente" name="tipo_cliente" required>
                                <option value="">-- Selecciona tipo --</option>
                                <option value="minorista" {{ old('tipo_cliente', $precio->tipo_cliente) == 'minorista' ? 'selected' : '' }}>Minorista</option>
                                <option value="mayorista" {{ old('tipo_cliente', $precio->tipo_cliente) == 'mayorista' ? 'selected' : '' }}>Mayorista</option>
                                <option value="distribuidor" {{ old('tipo_cliente', $precio->tipo_cliente) == 'distribuidor' ? 'selected' : '' }}>Distribuidor</option>
                            </select>
                            @error('tipo_cliente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                            <a href="{{ route('precios.index') }}" class="btn btn-secondary">
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
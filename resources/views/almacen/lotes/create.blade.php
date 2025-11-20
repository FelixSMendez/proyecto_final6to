@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus-circle me-2"></i> Ingreso de Lote
            </h1>
            <p class="text-muted small">Registrar nuevo lote de productos al inventario</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('almacen.lotes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Datos del Lote</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('almacen.lotes.store') }}" method="POST">
                        @csrf

                        <!-- Row 1: Producto y Detalle -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Producto <span class="text-danger">*</span></label>
                                <select name="id_detalleproducto" class="form-control @error('id_detalleproducto') is-invalid @enderror" required>
                                    <option value="">-- Seleccionar Producto --</option>
                                    @foreach($detalleProductos as $dp)
                                        <option value="{{ $dp->id }}" {{ old('id_detalleproducto') == $dp->id ? 'selected' : '' }}>
                                            {{ $dp->producto->nombre }} - {{ $dp->medida->nombre ?? 'Sin medida' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_detalleproducto')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Sucursal <span class="text-danger">*</span></label>
                                <select name="id_sucursal" class="form-control @error('id_sucursal') is-invalid @enderror" required>
                                    <option value="">-- Seleccionar Sucursal --</option>
                                    @foreach($sucursales as $suc)
                                        <option value="{{ $suc->id }}" {{ old('id_sucursal') == $suc->id ? 'selected' : '' }}>
                                            {{ $suc->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_sucursal')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Proveedor y Código Lote -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Proveedor <span class="text-danger">*</span></label>
                                <select name="id_proveedor" class="form-control @error('id_proveedor') is-invalid @enderror" required>
                                    <option value="">-- Seleccionar Proveedor --</option>
                                    @foreach($proveedores as $prov)
                                        <option value="{{ $prov->id }}" {{ old('id_proveedor') == $prov->id ? 'selected' : '' }}>
                                            {{ $prov->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_proveedor')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Código de Lote <span class="text-danger">*</span></label>
                                <input type="text" name="codLote" class="form-control @error('codLote') is-invalid @enderror" 
                                       placeholder="Ej: L-2025-001" value="{{ old('codLote') }}" required>
                                @error('codLote')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3: Cantidad y Costo Unitario -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                                <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" 
                                       placeholder="0" min="1" value="{{ old('cantidad') }}" required>
                                @error('cantidad')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Costo Unitario <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Q</span>
                                    <input type="number" name="costoUnidad" class="form-control @error('costoUnidad') is-invalid @enderror" 
                                           placeholder="0.00" step="0.01" min="0.01" value="{{ old('costoUnidad') }}" required>
                                </div>
                                @error('costoUnidad')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Precio de Venta <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Q</span>
                                    <input type="number" name="precio_venta" class="form-control @error('precio_venta') is-invalid @enderror" 
                                           placeholder="0.00" step="0.01" min="0.01" value="{{ old('precio_venta') }}" required>
                                </div>
                                @error('precio_venta')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 4: Fechas -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Entrada <span class="text-danger">*</span></label>
                                <input type="date" name="fechaEntrada" class="form-control @error('fechaEntrada') is-invalid @enderror" 
                                       value="{{ old('fechaEntrada', now()->format('Y-m-d')) }}" disabled>
                                <small class="text-muted">Se registra automáticamente hoy</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha de Caducidad <span class="text-danger">*</span></label>
                                <input type="date" name="fechaCaducidad" class="form-control @error('fechaCaducidad') is-invalid @enderror" 
                                       value="{{ old('fechaCaducidad') }}" required>
                                @error('fechaCaducidad')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Descripción (Opcional)</label>
                                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                                          rows="3" placeholder="Notas adicionales sobre el lote...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-save me-2"></i> Guardar Lote
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información de Ayuda -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-lightbulb me-2"></i> Información Importante
                </h6>
                <ul class="mb-0 small">
                    <li>El <strong>Código de Lote</strong> debe ser único en el sistema</li>
                    <li>La <strong>Cantidad</strong> debe ser mayor a 0</li>
                    <li>El <strong>Precio de Venta</strong> debe ser mayor al costo unitario</li>
                    <li>La <strong>Fecha de Caducidad</strong> no puede ser anterior a hoy</li>
                    <li>Al guardar, el inventario se actualizará automáticamente</li>
                </ul>
            </div>
        </div>

        <!-- Panel Lateral: Resumen -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">Resumen de Cálculos</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted">Costo Total del Lote:</label>
                        <h5 id="costoTotal" class="text-success">Q 0.00</h5>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted">Utilidad Estimada (por unidad):</label>
                        <h5 id="utilidad" class="text-warning">Q 0.00</h5>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted">Margen de Ganancia:</label>
                        <h5 id="margen" class="text-primary">0%</h5>
                    </div>
                    <hr>
                    <div>
                        <label class="small text-muted">Ingresos Estimados:</label>
                        <h5 id="ingresos" class="text-success font-weight-bold">Q 0.00</h5>
                    </div>
                </div>
            </div>

            <!-- Checklist de Validación -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">Checklist de Validación</h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check1" disabled>
                        <label class="form-check-label small" for="check1">
                            Producto seleccionado
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check2" disabled>
                        <label class="form-check-label small" for="check2">
                            Sucursal seleccionada
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check3" disabled>
                        <label class="form-check-label small" for="check3">
                            Cantidad válida
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check4" disabled>
                        <label class="form-check-label small" for="check4">
                            Precio de venta válido
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check5" disabled>
                        <label class="form-check-label small" for="check5">
                            Código de lote ingresado
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Cálculos en tiempo real
    const cantidadInput = document.querySelector('input[name="cantidad"]');
    const costoInput = document.querySelector('input[name="costoUnidad"]');
    const precioInput = document.querySelector('input[name="precio_venta"]');
    const productoSelect = document.querySelector('select[name="id_detalleproducto"]');
    const sucursalSelect = document.querySelector('select[name="id_sucursal"]');
    const codigoInput = document.querySelector('input[name="codLote"]');

    function actualizarCalculos() {
        const cantidad = parseFloat(cantidadInput.value) || 0;
        const costo = parseFloat(costoInput.value) || 0;
        const precio = parseFloat(precioInput.value) || 0;

        const costoTotal = cantidad * costo;
        const ingresosTotal = cantidad * precio;
        const utilidad = precio - costo;
        const margen = costo > 0 ? ((utilidad / costo) * 100).toFixed(2) : 0;

        document.getElementById('costoTotal').textContent = `Q ${costoTotal.toFixed(2)}`;
        document.getElementById('utilidad').textContent = `Q ${utilidad.toFixed(2)}`;
        document.getElementById('margen').textContent = `${margen}%`;
        document.getElementById('ingresos').textContent = `Q ${ingresosTotal.toFixed(2)}`;

        // Validaciones
        document.getElementById('check1').checked = productoSelect.value !== '';
        document.getElementById('check2').checked = sucursalSelect.value !== '';
        document.getElementById('check3').checked = cantidad > 0;
        document.getElementById('check4').checked = precio > 0;
        document.getElementById('check5').checked = codigoInput.value.trim() !== '';
    }

    cantidadInput.addEventListener('change', actualizarCalculos);
    costoInput.addEventListener('change', actualizarCalculos);
    precioInput.addEventListener('change', actualizarCalculos);
    productoSelect.addEventListener('change', actualizarCalculos);
    sucursalSelect.addEventListener('change', actualizarCalculos);
    codigoInput.addEventListener('input', actualizarCalculos);

    actualizarCalculos();
</script>
@endsection
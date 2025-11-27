@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('catalogo.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="fas fa-arrow-left me-2"></i> Volver al Catálogo
    </a>

    <div class="row">
        <!-- Imagen -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="height: 500px;">
                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                    <i class="fas fa-image fa-5x text-muted"></i>
                </div>
            </div>
        </div>

        <!-- Detalles -->
        <div class="col-md-6">
            <h1 class="mb-2">{{ $detalle->producto->nombre }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-primary">{{ $detalle->producto->tipoProducto->tipo ?? 'N/A' }}</span>
                <span class="badge bg-success">{{ $detalle->marca->marca ?? 'N/A' }}</span>
            </div>

            <p class="text-muted mb-4">{{ $detalle->descripcion }}</p>

            <!-- Precio -->
            <div class="card bg-light border-0 p-4 mb-4">
                @php
                    $precioMinorista = $detalle->obtenerPrecio('minorista');
                    $precioMayorista = $detalle->obtenerPrecio('mayorista');
                @endphp
                <h3 class="text-primary mb-2">Q{{ number_format($precioMinorista, 2) }}</h3>
                <p class="mb-0">
                    <strong>Medida:</strong> {{ $detalle->tipoMedida->nombre ?? 'N/A' }}<br>
                    <strong>Color:</strong> {{ $detalle->color_acabado ?? 'N/A' }}<br>
                    @if($precioMayorista)
                        <strong>Precio Mayorista:</strong> Q{{ number_format($precioMayorista, 2) }}
                    @endif
                </p>
            </div>

            <!-- Comprar -->
            <form action="{{ route('carrito.agregar', $detalle->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control form-control-lg" value="1" min="1">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-cart-plus me-2"></i> Agregar al Carrito
                </button>
            </form>

            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="card-title fw-bold">Información</h6>
                    <ul class="list-unstyled">
                        <li><strong>Tipo:</strong> {{ $detalle->producto->tipoProducto->tipo ?? 'N/A' }}</li>
                        <li><strong>Marca:</strong> {{ $detalle->marca->marca ?? 'N/A' }}</li>
                        <li><strong>Medida:</strong> {{ $detalle->tipoMedida->tipo ?? 'N/A' }}</li>
                        <li><strong>Color:</strong> {{ $detalle->color_acabado ?? 'N/A' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Similares -->
    @if($productosSimilares->count() > 0)
        <div class="row mt-5">
            <div class="col-12"><h4 class="mb-4">Productos Similares</h4></div>
            @foreach($productosSimilares as $similar)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div style="height: 200px; background-color: #f0f0f0;" class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-2x text-muted"></i>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">{{ $similar->producto->nombre }}</h6>
                            <p class="text-primary fw-bold">Q{{ number_format($similar->producto->precio->precio ?? 0, 2) }}</p>
                            <a href="{{ route('catalogo.show', $similar->id) }}" class="btn btn-sm btn-outline-primary w-100">
                                Ver Producto
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
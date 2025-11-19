@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('catalogo.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="fas fa-arrow-left me-2"></i> Volver al Catálogo
    </a>

    <div class="row">
        <!-- Imagen -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="height: 500px; overflow: hidden;">
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="card-img h-100" style="object-fit: cover;">
                @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detalles -->
        <div class="col-md-6">
            <h1 class="mb-2">{{ $producto->nombre }}</h1>
            
            <!-- Badges -->
            <div class="mb-3">
                <span class="badge bg-primary">{{ $producto->tipo->tipo ?? 'N/A' }}</span>
                <span class="badge bg-success">{{ $producto->marca->marca ?? 'N/A' }}</span>
            </div>

            <p class="text-muted mb-4">{{ $producto->descripcion }}</p>

            <!-- Precio y Stock -->
            <div class="card bg-light border-0 p-4 mb-4">
                <h3 class="text-primary mb-2">Q{{ number_format($producto->precio, 2) }}</h3>
                <p class="mb-0">
                    <strong>Stock disponible:</strong> 
                    <span class="badge bg-{{ $producto->stock > 0 ? 'success' : 'danger' }}">
                        {{ $producto->stock > 0 ? $producto->stock . ' unidades' : 'Agotado' }}
                    </span>
                </p>
            </div>

            <!-- Formulario de compra -->
            @if($producto->stock > 0)
                <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control form-control-lg" value="1" min="1" max="{{ $producto->stock }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-cart-plus me-2"></i> Agregar al Carrito
                    </button>
                </form>
            @else
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> Producto agotado
                </div>
            @endif

            <!-- Info adicional -->
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="card-title fw-bold">Características</h6>
                    <ul class="list-unstyled">
                        <li><strong>Medida:</strong> {{ $producto->medida->medida ?? 'N/A' }}</li>
                        <li><strong>Tipo:</strong> {{ $producto->tipo->tipo ?? 'N/A' }}</li>
                        <li><strong>Marca:</strong> {{ $producto->marca->marca ?? 'N/A' }}</li>
                        <li><strong>SKU:</strong> {{ $producto->id }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos similares -->
    @if($productosSimilares->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="mb-4">Productos Similares</h4>
            </div>
            @foreach($productosSimilares as $similar)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div style="height: 200px; overflow: hidden; background-color: #f0f0f0;">
                            @if($similar->imagen)
                                <img src="{{ asset('storage/' . $similar->imagen) }}" alt="{{ $similar->nombre }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">{{ $similar->nombre }}</h6>
                            <p class="text-primary fw-bold">Q{{ number_format($similar->precio, 2) }}</p>
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
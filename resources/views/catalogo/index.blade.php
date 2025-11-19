@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background-color: #f8f9fa;">
    <!-- Header con Hero -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-5 text-center text-white rounded" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 250px; display: flex; flex-direction: column; justify-content: center;">
                <h1 class="display-4 fw-bold mb-3">CATÁLOGO DE PRODUCTOS</h1>
                <p class="lead">Descuentos increíbles en pinturas y accesorios</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- SIDEBAR FILTROS -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-filter me-2"></i> Filtros
                </div>
                <div class="card-body">
                    <form action="{{ route('catalogo.index') }}" method="GET" id="filterForm">
                        <!-- Búsqueda -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Buscar</label>
                            <input type="text" class="form-control" name="buscar" placeholder="Nombre o descripción" value="{{ request('buscar') }}">
                        </div>

                        <!-- Tipo de Producto -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tipo de Producto</label>
                            <div class="list-group list-group-flush">
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="tipo" value="" {{ !request('tipo') ? 'checked' : '' }}>
                                    Todos
                                </label>
                                @foreach($tipos as $tipo)
                                    <label class="list-group-item">
                                        <input class="form-check-input me-2" type="radio" name="tipo" value="{{ $tipo->id }}" {{ request('tipo') == $tipo->id ? 'checked' : '' }}>
                                        {{ $tipo->tipo }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Marca -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Marca</label>
                            <div class="list-group list-group-flush">
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="marca" value="" {{ !request('marca') ? 'checked' : '' }}>
                                    Todas
                                </label>
                                @foreach($marcas as $marca)
                                    <label class="list-group-item">
                                        <input class="form-check-input me-2" type="radio" name="marca" value="{{ $marca->id }}" {{ request('marca') == $marca->id ? 'checked' : '' }}>
                                        {{ $marca->marca }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Ordenar -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ordenar por</label>
                            <select class="form-select" name="orden" onchange="document.getElementById('filterForm').submit()">
                                <option value="reciente" {{ request('orden') == 'reciente' ? 'selected' : '' }}>Más Recientes</option>
                                <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Menor Precio</option>
                                <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Mayor Precio</option>
                                <option value="nombre" {{ request('orden') == 'nombre' ? 'selected' : '' }}>Nombre (A-Z)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i> Buscar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- PRODUCTOS GRID -->
        <div class="col-lg-9">
            <!-- Contador de productos -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">
                    <strong>{{ $productos->total() }}</strong> productos encontrados
                </h5>
                <a href="{{ route('carrito.index') }}" class="btn btn-outline-success">
                    <i class="fas fa-shopping-cart me-2"></i> Ver Carrito
                </a>
            </div>

            <!-- Grid de productos -->
            @if($productos->count() > 0)
                <div class="row g-4">
                    @foreach($productos as $producto)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100 transition" style="overflow: hidden;">
                                <!-- Imagen del producto -->
                                <div style="height: 250px; overflow: hidden; background-color: #f0f0f0; position: relative;">
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                            <i class="fas fa-image fa-3x"></i>
                                        </div>
                                    @endif
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">OFERTA</span>
                                </div>

                                <!-- Info del producto -->
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-bold">{{ $producto->nombre }}</h6>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($producto->descripcion, 60) }}
                                    </p>

                                    <!-- Marca y Tipo -->
                                    <div class="small mb-2">
                                        <span class="badge bg-light text-dark">{{ $producto->marca->marca ?? 'N/A' }}</span>
                                        <span class="badge bg-light text-dark">{{ $producto->tipo->tipo ?? 'N/A' }}</span>
                                    </div>

                                    <!-- Precio -->
                                    <div class="my-3">
                                        <h5 class="mb-0 text-primary">
                                            Q{{ number_format($producto->precio, 2) }}
                                        </h5>
                                        <small class="text-muted">
                                            Stock: {{ $producto->stock }} unidades
                                        </small>
                                    </div>

                                    <!-- Botones -->
                                    <div class="mt-auto">
                                        <a href="{{ route('catalogo.show', $producto->id) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                                            <i class="fas fa-eye me-1"></i> Ver Detalles
                                        </a>
                                        <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            <div class="input-group input-group-sm mb-2">
                                                <input type="number" name="cantidad" class="form-control" value="1" min="1" max="{{ $producto->stock }}">
                                                <button class="btn btn-primary" type="submit" {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-cart-plus"></i> Agregar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $productos->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p class="mb-0">No hay productos que coincidan con los filtros seleccionados</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .transition {
        transition: all 0.3s ease;
    }
    .transition:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endsection
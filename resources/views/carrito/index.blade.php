@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">
        <i class="fas fa-shopping-cart me-2"></i> Mi Carrito
    </h2>

    @if(count($carrito) > 0)
        <div class="row">
            <!-- Lista de productos -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carrito as $id => $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item['nombre'] }}</strong>
                                        </td>
                                        <td>
                                            Q{{ number_format($item['precio'], 2) }}
                                        </td>
                                        <td>
                                            <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="cantidad" class="form-control" value="{{ $item['cantidad'] }}" min="1" max="100" style="width: 60px;">
                                                    <button class="btn btn-outline-secondary btn-sm" type="submit">Actualizar</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <strong>Q{{ number_format($item['precio'] * $item['cantidad'], 2) }}</strong>
                                        </td>
                                        <td>
                                            <form action="{{ route('carrito.quitar', $id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <a href="{{ route('catalogo.index') }}" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-arrow-left me-2"></i> Seguir Comprando
                </a>
            </div>

            <!-- Resumen de compra -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Resumen de Compra</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>Q{{ number_format($total, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío:</span>
                            <strong>Q0.00</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-primary" style="font-size: 1.3rem;">Q{{ number_format($total, 2) }}</strong>
                        </div>

                        <button class="btn btn-success btn-lg w-100 mb-2" disabled>
                            <i class="fas fa-lock me-2"></i> Proceder al Pago
                        </button>
                        <small class="text-muted d-block text-center">(Función de pago próximamente)</small>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-shopping-cart fa-5x mb-3 text-muted"></i>
            <h4>Tu carrito está vacío</h4>
            <p class="text-muted">Explora nuestro catálogo y agrega productos a tu carrito</p>
            <a href="{{ route('catalogo.index') }}" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag me-2"></i> Ver Catálogo
            </a>
        </div>
    @endif
</div>
@endsection
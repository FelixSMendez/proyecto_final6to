@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">🛒 Mi Carrito</h2>

    @if(count($carrito) > 0)
        <div class="row">
            <!-- TABLA DE PRODUCTOS -->
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
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
                                @php
                                    $subtotal = $item['precio'] * $item['cantidad'];
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $item['nombre'] }}</strong><br>
                                        <small class="text-muted">
                                            {{ $item['marca'] }} | {{ $item['medida'] }} | {{ $item['color'] }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>Q{{ number_format($item['precio'], 2) }}</strong>
                                    </td>
                                    <td>
                                        <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="form-control">
                                                <button type="submit" class="btn btn-outline-secondary">✓</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <strong>Q{{ number_format($subtotal, 2) }}</strong>
                                    </td>
                                    <td>
                                        <form action="{{ route('carrito.quitar', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('catalogo.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i> Seguir Comprando
                </a>
            </div>

            <!-- RESUMEN DE COMPRA -->
            <div class="col-lg-4">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Resumen de Compra</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $subtotal = 0;
                            foreach($carrito as $item) {
                                $subtotal += $item['precio'] * $item['cantidad'];
                            }
                            $envio = 0; // Puedes cambiar esto
                            $total = $subtotal + $envio;
                        @endphp
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>Q{{ number_format($subtotal, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                            <span>Envío:</span>
                            <strong>Q{{ number_format($envio, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <h5>Total:</h5>
                            <h4 class="text-primary">Q{{ number_format($total, 2) }}</h4>
                        </div>

                        <form action="{{ route('factura.store') }}" method="POST" class="w-100">
                            @csrf
    
                            @auth('cliente')
                                {{-- Si el cliente está autenticado, envía su ID automáticamente --}}
                                <input type="hidden" name="id_cliente" value="{{ auth('cliente')->id() }}">
                            @else
                                {{-- Si no está autenticado, muestra un selector --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Selecciona tu Usuario</label>
                                    <select name="id_cliente" class="form-select" required>
                                        <option value="">-- Seleccionar Cliente --</option>
                                        @foreach(\App\Models\UsuarioCliente::all() as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->usuario }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endauth

                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-lock me-2"></i> Proceder al Pago
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
            <p class="mb-3">Tu carrito está vacío</p>
            <a href="{{ route('catalogo.index') }}" class="btn btn-primary">
                Ir al Catálogo
            </a>
        </div>
    @endif
</div>
@endsection
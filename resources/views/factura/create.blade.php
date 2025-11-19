@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">📋 Resumen de Pedido</h2>

    <form action="{{ route('factura.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <!-- Datos Cliente -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tu Información</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Cliente</label>
                            <select class="form-select" name="id_cliente" required>
                                <option>-- Seleccionar Cliente --</option>
                                @foreach(\App\Models\UsuarioCliente::all() as $cliente)
                                    <option value="{{ $cliente->id }}" 
                                        {{ auth('cliente')->id() == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->usuario }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Resumen del Pedido</h5>
                    </div>
                    <div class="card-body">
                        @php $total = 0; @endphp
                        @foreach($carrito as $item)
                            @php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $item['nombre'] }} (x{{ $item['cantidad'] }})</span>
                                <strong>Q{{ number_format($subtotal, 2) }}</strong>
                            </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5>TOTAL:</h5>
                            <h4 class="text-primary">Q{{ number_format($total, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('carrito.index') }}" class="btn btn-secondary">Volver al Carrito</a>
            <button type="submit" class="btn btn-success btn-lg">Proceder al Pago</button>
        </div>
    </form>
</div>
@endsection
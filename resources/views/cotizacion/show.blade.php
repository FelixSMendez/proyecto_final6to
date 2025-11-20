@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2>Cotización #{{ $cotizacion->id }}</h2>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Información General</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Cliente:</strong> {{ $cotizacion->cliente->usuario }}</p>
                            <p><strong>Email:</strong> {{ $cotizacion->cliente->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fecha Emisión:</strong> {{ $cotizacion->fecha->format('d/m/Y') }}</p>
                            <p><strong>Válida hasta:</strong> {{ $cotizacion->fecha_vencimiento->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <p>
                        <strong>Estado:</strong> 
                        <span class="badge bg-{{ $cotizacion->estado === 'aceptada' ? 'success' : ($cotizacion->estado === 'rechazada' ? 'danger' : 'warning') }}">
                            {{ ucfirst($cotizacion->estado) }}
                        </span>
                    </p>
                </div>
            </div>

            <h5>Detalles de Productos</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cotizacion->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->detalleProducto->producto->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>Q {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>Q {{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resumen</h5>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total:</span>
                        <strong>Q {{ number_format($cotizacion->total, 2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('cotizacion.pdf', $cotizacion->id) }}" class="btn btn-primary w-100 mb-2" target="_blank">
                    <i class="fas fa-download"></i> Descargar PDF
                </a>
                
                <a href="{{ route('catalogo.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="fas fa-arrow-left"></i> Volver al Catálogo
                </a>

                @if($cotizacion->estado === 'pendiente')
                <form method="POST" action="{{ route('cotizacion.estado', $cotizacion->id) }}">
                    @csrf
                    <input type="hidden" name="estado" value="aceptada">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check"></i> Aceptar Cotización
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
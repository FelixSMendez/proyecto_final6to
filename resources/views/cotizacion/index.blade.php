@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Mis Cotizaciones</h2>
    
    @if($cotizaciones->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizaciones as $cot)
                <tr>
                    <td>{{ $cot->id }}</td>
                    <td>{{ $cot->cliente->usuario }}</td>
                    <td>Q {{ number_format($cot->total, 2) }}</td>
                    <td>{{ $cot->fecha->format('d/m/Y') }}</td>
                    <td>{{ $cot->fecha_vencimiento->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $cot->estado === 'aceptada' ? 'success' : ($cot->estado === 'rechazada' ? 'danger' : 'warning') }}">
                            {{ ucfirst($cot->estado) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('cotizacion.show', $cot->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('cotizacion.pdf', $cot->id) }}" class="btn btn-sm btn-primary" target="_blank">PDF</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No tienes cotizaciones aún</p>
    @endif
</div>
@endsection
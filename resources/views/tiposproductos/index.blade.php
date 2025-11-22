@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tipos de Productos</h2>
    <a href="{{ route('tipoproductos.create') }}" class="btn btn-success mb-3">Nuevo Tipo de Producto</a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th><th>Tipo</th><th>Descripción</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipos as $tipo)
            <tr>
                <td>{{ $tipo->id }}</td>
                <td>{{ $tipo->tipo }}</td>
                <td>{{ $tipo->descripcion }}</td>
                <td>
                    <a href="{{ route('tipoproductos.edit', $tipo) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form method="POST" action="{{ route('tipoproductos.destroy', $tipo) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Borrar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

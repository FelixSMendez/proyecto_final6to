<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Sucursales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1 class="mb-4">Sucursales</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('sucursales.create') }}" class="btn btn-primary mb-3">Nueva Sucursal</a>
    <a href="/" class="btn btn-warning mb-3">Regresar</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($sucursales as $sucursal)
            <tr>
                <td>{{ $sucursal->id }}</td>
                <td>{{ $sucursal->nombre }}</td>
                <td>{{ $sucursal->direccion }}</td>
                <td>{{ $sucursal->ciudad }}</td>
                <td>
                    <a href="{{ route('sucursales.edit', $sucursal) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('sucursales.destroy', $sucursal) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Seguro que deseas eliminar esta sucursal?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>

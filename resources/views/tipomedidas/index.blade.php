<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Tipos de Medida</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1 class="mb-4">Tipos de Medida</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('tipomedidas.create') }}" class="btn btn-primary mb-3">Nuevo Tipo</a>
    <a href="/" class="btn btn-warning mb-3">Regresar</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($tipomedidas as $tipomedida)
            <tr>
                <td>{{ $tipomedida->id }}</td>
                <td>{{ $tipomedida->tipo }}</td>
                <td>{{ $tipomedida->descripcion }}</td>
                <td>
                    <a href="{{ route('tipomedidas.edit', $tipomedida) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('tipomedidas.destroy', $tipomedida) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Seguro que deseas eliminar este tipo de medida?')">
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

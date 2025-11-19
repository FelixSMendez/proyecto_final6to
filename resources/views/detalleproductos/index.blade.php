<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Detalle de Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Detalle de Productos</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('detalleproductos.create') }}" class="btn btn-primary mb-3">Nuevo Detalle</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Tipo de Medida</th>
        <th>Color</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($detalles as $detalle)
        <tr>
          <td>{{ $detalle->id }}</td>
          <td>{{ $detalle->tipoMedida?->tipo ?? '-' }}</td>
          <td>{{ $detalle->color }}</td>
          <td>{{ $detalle->descripcion }}</td>
          <td>
            <a href="{{ route('detalleproductos.edit', $detalle->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('detalleproductos.destroy', $detalle->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este detalle de producto?')">
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

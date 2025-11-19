<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Inventario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Inventario</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('inventario.create') }}" class="btn btn-primary mb-3">Nuevo Inventario</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Lote</th>
        <th>Sucursal</th>
        <th>Existencia</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($inventarios as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->lote->codLote ?? '-' }}</td>
          <td>{{ $item->sucursal->nombre ?? '-' }}</td>
          <td>{{ $item->existencia }}</td>
          <td>
            <a href="{{ route('inventario.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
            <form action="{{ route('inventario.destroy', $item->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este inventario?')">
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

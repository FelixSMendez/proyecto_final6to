<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Lotes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Lotes</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('lotes.create') }}" class="btn btn-primary mb-3">Nuevo Lote</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Marca</th>
        <th>Cantidad</th>
        <th>Costo Unidad</th>
        <th>Fecha Caducidad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($lotes as $lote)
        <tr>
          <td>{{ $lote->id }}</td>
          <td>{{ $lote->producto->nombre ?? '-' }}</td>
          <td>{{ $lote->marca->nombre ?? '-' }}</td>
          <td>{{ $lote->cantidad }}</td>
          <td>{{ $lote->costoUnidad }}</td>
          <td>{{ $lote->fechaCaducidad }}</td>
          <td>
            <a href="{{ route('lotes.edit', $lote->id) }}" class="btn btn-warning btn-sm">Editar</a>
            <form action="{{ route('lotes.destroy', $lote->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este lote?')">
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

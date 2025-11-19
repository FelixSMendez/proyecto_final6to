<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista Detalle de Carritos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Detalle de Carritos</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('detallecarritos.create') }}" class="btn btn-primary mb-3">Nuevo Detalle</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Carrito</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($detalles as $detalle)
        <tr>
          <td>{{ $detalle->id }}</td>
          <td>{{ $detalle->carrito ? $detalle->carrito->id : '-' }}</td>
          <td>{{ $detalle->producto ? $detalle->producto->nombre : '-' }}</td>
          <td>{{ $detalle->cantidad }}</td>
          <td>
            <a href="{{ route('detallecarritos.edit', $detalle->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('detallecarritos.destroy', $detalle->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este detalle?')">
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

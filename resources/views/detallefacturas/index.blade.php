<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Detalle Facturas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Detalle Facturas</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('detallefacturas.create') }}" class="btn btn-primary mb-3">Nuevo Detalle</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Factura</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Descuento</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($detalles as $detalle)
        <tr>
          <td>{{ $detalle->id }}</td>
          <td>{{ $detalle->factura->id ?? '' }}</td>
          <td>{{ $detalle->producto->nombre ?? '' }}</td>
          <td>{{ $detalle->cantidad }}</td>
          <td>{{ $detalle->preciounitario }}</td>
          <td>{{ $detalle->descuento }}</td>
          <td>
            <a href="{{ route('detallefacturas.edit', $detalle->id) }}" class="btn btn-warning btn-sm">Editar</a>
            <form action="{{ route('detallefacturas.destroy', $detalle->id) }}" method="POST" style="display:inline">
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

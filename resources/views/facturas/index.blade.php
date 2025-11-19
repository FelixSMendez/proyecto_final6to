<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Facturas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Facturas</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('facturas.create') }}" class="btn btn-primary mb-3">Nueva Factura</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Correlativo</th>
        <th>Serie</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Empleado</th>
        <th>Sucursal</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($facturas as $factura)
        <tr>
          <td>{{ $factura->id }}</td>
          <td>{{ $factura->correlativo }}</td>
          <td>{{ $factura->letra_serie }}</td>
          <td>{{ $factura->fecha }}</td>
          <td>{{ $factura->cliente->nombre }}</td>
          <td>{{ $factura->empleado->nombre }}</td>
          <td>{{ $factura->sucursal->nombre }}</td>
          <td>
            <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar esta factura?')">
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

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Cotizaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Cotizaciones</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('cotizaciones.create') }}" class="btn btn-primary mb-3">Nueva Cotización</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($cotizaciones as $cotizacion)
        <tr>
          <td>{{ $cotizacion->id }}</td>
          <td>{{ $cotizacion->cliente ? $cotizacion->cliente->nombre : '-' }}</td>
          <td>{{ $cotizacion->fecha }}</td>
          <td>{{ $cotizacion->total }}</td>
          <td>
            <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar esta cotización?')">
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

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Precios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Precios</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('precios.create') }}" class="btn btn-primary mb-3">Nuevo Precio</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Precio Venta</th>
        <th>Descuento</th>
        <th>Tipo de Medida</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($precios as $precio)
        <tr>
          <td>{{ $precio->id }}</td>
          <td>{{ $precio->tipo }}</td>
          <td>{{ $precio->precioVenta }}</td>
          <td>{{ $precio->descuento }}</td>
          <td>{{ $precio->tipoMedida?->tipo ?? '-' }}</td>
          <td>
            <a href="{{ route('precios.edit', $precio->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('precios.destroy', $precio->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este precio?')">
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

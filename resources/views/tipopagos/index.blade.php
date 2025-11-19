<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Tipos de Pago</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Tipos de Pago</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('tipopagos.create') }}" class="btn btn-primary mb-3">Nuevo Tipo de Pago</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tipopagos as $tipopago)
        <tr>
          <td>{{ $tipopago->id }}</td>
          <td>{{ $tipopago->nombre }}</td>
          <td>{{ $tipopago->descripcion }}</td>
          <td>
            <a href="{{ route('tipopagos.edit', $tipopago->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('tipopagos.destroy', $tipopago->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este tipo de pago?')">
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

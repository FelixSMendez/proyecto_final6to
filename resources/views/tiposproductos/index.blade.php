<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Tipos de Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Tipos de Producto</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('tiposproductos.create') }}" class="btn btn-primary mb-3">Nuevo Tipo</a>
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
      @foreach ($tipos as $tiposproducto)
        <tr>
          <td>{{ $tiposproducto->id }}</td>
          <td>{{ $tiposproducto->nombre }}</td>
          <td>{{ $tiposproducto->descripcion }}</td>
          <td>
            <a href="{{ route('tiposproductos.edit', $tiposproducto->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('tiposproductos.destroy', $tiposproducto->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este tipo de producto?')">
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

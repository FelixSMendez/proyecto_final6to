<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Proveedores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Proveedores</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3">Nuevo Proveedor</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Contacto</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($proveedores as $proveedor)
        <tr>
          <td>{{ $proveedor->id }}</td>
          <td>{{ $proveedor->nombre }}</td>
          <td>{{ $proveedor->contacto }}</td>
          <td>{{ $proveedor->direccion }}</td>
          <td>{{ $proveedor->telefono }}</td>
          <td>
            <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este proveedor?')">
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

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista Usuarios del Sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Usuarios del Sistema</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('usuariosistema.create') }}" class="btn btn-primary mb-3">Nuevo Usuario</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Empleado</th>
        <th>Cliente</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($usuarios as $usuario)
        <tr>
          <td>{{ $usuario->id }}</td>
          <td>{{ $usuario->usuario }}</td>
          <td>{{ $usuario->empleado ? $usuario->empleado->nombre : '-' }}</td>
          <td>{{ $usuario->cliente ? $usuario->cliente->nombre : '-' }}</td>
          <td>
            <a href="{{ route('usuariosistema.edit', $usuario->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('usuariosistema.destroy', $usuario->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
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

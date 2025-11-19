<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Usuario del Sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Registrar Usuario</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('usuariosistema.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="usuario" class="form-label">Usuario</label>
      <input type="text" name="usuario" id="usuario" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="contrasena" class="form-label">Contraseña</label>
      <input type="password" name="contrasena" id="contrasena" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="id_empleado" class="form-label">Empleado</label>
      <select name="id_empleado" id="id_empleado" class="form-select">
        <option value="">-- Ninguno --</option>
        @foreach($empleados as $empleado)
          <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_cliente" class="form-label">Cliente</label>
      <select name="id_cliente" id="id_cliente" class="form-select">
        <option value="">-- Ninguno --</option>
        @foreach($clientes as $cliente)
          <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('usuariosistema.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>

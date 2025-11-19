<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Empleado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Registrar Empleado</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('empleados.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre *</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="apellido" class="form-label">Apellido *</label>
      <input type="text" name="apellido" id="apellido" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="mb-3">
      <label for="id_rol" class="form-label">Rol</label>
      <select name="id_rol" id="id_rol" class="form-control">
        <option value="">-- Seleccione un rol --</option>
        @foreach($roles as $rol)
          <option value="{{ $rol->id }}">{{ $rol->tipo }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

</body>
</html>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Registrar Cliente</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('clientes.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre *</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección</label>
      <input type="text" name="direccion" id="direccion" class="form-control">
    </div>
    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono</label>
      <input type="text" name="telefono" id="telefono" class="form-control">
    </div>
    <div class="mb-3">
      <label for="gps" class="form-label">GPS</label>
      <input type="text" name="gps" id="gps" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>

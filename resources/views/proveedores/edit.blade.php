<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Proveedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Editar Proveedor</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre *</label>
      <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $proveedor->nombre }}" required>
    </div>
    <div class="mb-3">
      <label for="contacto" class="form-label">Contacto</label>
      <input type="text" name="contacto" id="contacto" class="form-control" value="{{ $proveedor->contacto }}">
    </div>
    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección</label>
      <input type="text" name="direccion" id="direccion" class="form-control" value="{{ $proveedor->direccion }}">
    </div>
    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono</label>
      <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $proveedor->telefono }}">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>

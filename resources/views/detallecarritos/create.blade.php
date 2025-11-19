<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Detalle de Carrito</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Registrar Detalle de Carrito</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('detallecarritos.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="id_carrito" class="form-label">Carrito</label>
      <select name="id_carrito" id="id_carrito" class="form-select" required>
        <option value="">-- Seleccionar Carrito --</option>
        @foreach($carritos as $carrito)
          <option value="{{ $carrito->id }}">{{ $carrito->id }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_producto" class="form-label">Producto</label>
      <select name="id_producto" id="id_producto" class="form-select" required>
        <option value="">-- Seleccionar Producto --</option>
        @foreach($productos as $producto)
          <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="cantidad" class="form-label">Cantidad</label>
      <input type="number" name="cantidad" id="cantidad" class="form-control" min="1">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('detallecarritos.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>

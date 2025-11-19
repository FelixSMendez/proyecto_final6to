<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Detalle de Carrito</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Detalle de Carrito</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('detallecarritos.update', $detallecarrito) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="id_carrito" class="form-label">Carrito</label>
      <select name="id_carrito" id="id_carrito" class="form-select" required>
        @foreach($carritos as $carrito)
          <option value="{{ $carrito->id }}" {{ $detallecarrito->id_carrito == $carrito->id ? 'selected' : '' }}>
            {{ $carrito->id }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_producto" class="form-label">Producto</label>
      <select name="id_producto" id="id_producto" class="form-select" required>
        @foreach($productos as $producto)
          <option value="{{ $producto->id }}" {{ $detallecarrito->id_producto == $producto->id ? 'selected' : '' }}>
            {{ $producto->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="cantidad" class="form-label">Cantidad</label>
      <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" value="{{ $detallecarrito->cantidad }}">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('detallecarritos.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>

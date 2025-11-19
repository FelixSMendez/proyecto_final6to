<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Detalle de Cotización</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Detalle de Cotización</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('detallecotizaciones.update', $detallecotizacion) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="id_cotizacion" class="form-label">Cotización</label>
      <select name="id_cotizacion" id="id_cotizacion" class="form-select" required>
        @foreach($cotizaciones as $cotizacion)
          <option value="{{ $cotizacion->id }}" {{ $detallecotizacion->id_cotizacion == $cotizacion->id ? 'selected' : '' }}>
            {{ $cotizacion->id }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_producto" class="form-label">Producto</label>
      <select name="id_producto" id="id_producto" class="form-select" required>
        @foreach($productos as $producto)
          <option value="{{ $producto->id }}" {{ $detallecotizacion->id_producto == $producto->id ? 'selected' : '' }}>
            {{ $producto->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="cantidad" class="form-label">Cantidad</label>
      <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" value="{{ $detallecotizacion->cantidad }}" required>
    </div>

    <div class="mb-3">
      <label for="precio_unitario" class="form-label">Precio Unitario</label>
      <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" class="form-control" value="{{ $detallecotizacion->precio_unitario }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('detallecotizaciones.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>

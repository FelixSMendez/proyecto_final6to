<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Detalle Factura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Detalle Factura</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('detallefacturas.update', $detallefactura) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="id_factura" class="form-label">Factura *</label>
      <select name="id_factura" id="id_factura" class="form-control" required>
        @foreach($facturas as $factura)
          <option value="{{ $factura->id }}" {{ $detallefactura->id_factura == $factura->id ? 'selected' : '' }}>
            {{ $factura->id }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_producto" class="form-label">Producto *</label>
      <select name="id_producto" id="id_producto" class="form-control" required>
        @foreach($productos as $producto)
          <option value="{{ $producto->id }}" {{ $detallefactura->id_producto == $producto->id ? 'selected' : '' }}>
            {{ $producto->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="cantidad" class="form-label">Cantidad *</label>
      <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $detallefactura->cantidad }}" min="1" required>
    </div>

    <div class="mb-3">
      <label for="preciounitario" class="form-label">Precio Unitario *</label>
      <input type="number" name="preciounitario" id="preciounitario" class="form-control" value="{{ $detallefactura->preciounitario }}" step="0.01" min="0" required>
    </div>

    <div class="mb-3">
      <label for="descuento" class="form-label">Descuento</label>
      <input type="number" name="descuento" id="descuento" class="form-control" value="{{ $detallefactura->descuento }}" step="0.01" min="0">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('detallefacturas.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

</body>
</html>

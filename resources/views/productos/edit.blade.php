<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Producto</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('productos.update', $producto) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre *</label>
      <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $producto->nombre }}" required>
    </div>

    <div class="mb-3">
      <label for="stock" class="form-label">Stock *</label>
      <input type="number" name="stock" id="stock" class="form-control" value="{{ $producto->stock }}" required min="0">
    </div>

    <div class="mb-3">
      <label for="id_tipoProducto" class="form-label">Tipo de Producto</label>
      <select name="id_tipoProducto" id="id_tipoProducto" class="form-select">
        <option value="">-- Seleccione --</option>
        @foreach($tiposProducto as $tipo)
          <option value="{{ $tipo->id }}" {{ $producto->id_tipoProducto == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_proveedor" class="form-label">Proveedor</label>
      <select name="id_proveedor" id="id_proveedor" class="form-select">
        <option value="">-- Seleccione --</option>
        @foreach($proveedores as $proveedor)
          <option value="{{ $proveedor->id }}" {{ $producto->id_proveedor == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_detalleProducto" class="form-label">Detalle Producto</label>
      <select name="id_detalleProducto" id="id_detalleProducto" class="form-select">
        <option value="">-- Seleccione --</option>
        @foreach($detalles as $detalle)
          <option value="{{ $detalle->id }}" {{ $producto->id_detalleProducto == $detalle->id ? 'selected' : '' }}>
            Color: {{ $detalle->color }} | {{ $detalle->descripcion }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_precio" class="form-label">Precio</label>
      <select name="id_precio" id="id_precio" class="form-select">
        <option value="">-- Seleccione --</option>
        @foreach($precios as $precio)
          <option value="{{ $precio->id }}" {{ $producto->id_precio == $precio->id ? 'selected' : '' }}>
            {{ $precio->tipo }} - {{ $precio->precioVenta }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

</body>
</html>

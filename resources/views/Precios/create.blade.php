<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Precio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Registrar Precio</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('precios.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="tipo" class="form-label">Tipo</label>
      <input type="text" name="tipo" id="tipo" class="form-control">
    </div>

    <div class="mb-3">
      <label for="precioVenta" class="form-label">Precio Venta</label>
      <input type="number" step="0.01" name="precioVenta" id="precioVenta" class="form-control">
    </div>

    <div class="mb-3">
      <label for="descuento" class="form-label">Descuento (%)</label>
      <input type="number" step="0.01" name="descuento" id="descuento" class="form-control">
    </div>

    <div class="mb-3">
      <label for="id_tipoMedida" class="form-label">Tipo de Medida</label>
      <select name="id_tipoMedida" id="id_tipoMedida" class="form-control">
        <option value="">Seleccione...</option>
        @foreach ($tiposMedida as $tipo)
          <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('precios.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>

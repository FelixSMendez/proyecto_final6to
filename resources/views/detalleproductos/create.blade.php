<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Detalle de Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Registrar Detalle de Producto</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('detalleproductos.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="id_tipoMedida" class="form-label">Tipo de Medida *</label>
      <select name="id_tipoMedida" id="id_tipoMedida" class="form-control" required>
        <option value="">Seleccione...</option>
        @foreach ($tiposMedida as $tipo)
          <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="color" class="form-label">Color</label>
      <input type="text" name="color" id="color" class="form-control">
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <input type="text" name="descripcion" id="descripcion" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('detalleproductos.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>

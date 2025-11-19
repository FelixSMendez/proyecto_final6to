<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Inventario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Registrar Inventario</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('inventario.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="id_lote" class="form-label">Lote *</label>
      <select name="id_lote" id="id_lote" class="form-control" required>
        <option value="">Seleccione</option>
        @foreach($lotes as $lote)
          <option value="{{ $lote->id }}">{{ $lote->codLote }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_sucursal" class="form-label">Sucursal *</label>
      <select name="id_sucursal" id="id_sucursal" class="form-control" required>
        <option value="">Seleccione</option>
        @foreach($sucursales as $sucursal)
          <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="existencia" class="form-label">Existencia *</label>
      <input type="number" name="existencia" id="existencia" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>

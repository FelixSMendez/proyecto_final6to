<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Lote</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Registrar Lote</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('lotes.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="id_producto" class="form-label">Producto *</label>
      <select name="id_producto" id="id_producto" class="form-control" required>
        <option value="">Seleccione</option>
        @foreach($productos as $producto)
          <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_marca" class="form-label">Marca</label>
      <select name="id_marca" id="id_marca" class="form-control">
        <option value="">Seleccione</option>
        @foreach($marcas as $marca)
          <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="cantidad" class="form-label">Cantidad *</label>
      <input type="number" name="cantidad" id="cantidad" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="costoUnidad" class="form-label">Costo Unidad *</label>
      <input type="number" step="0.01" name="costoUnidad" id="costoUnidad" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="fechaEntrada" class="form-label">Fecha Entrada *</label>
      <input type="date" name="fechaEntrada" id="fechaEntrada" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="fechaCaducidad" class="form-label">Fecha Caducidad *</label>
      <input type="date" name="fechaCaducidad" id="fechaCaducidad" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="codLote" class="form-label">Código Lote *</label>
      <input type="text" name="codLote" id="codLote" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('lotes.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>

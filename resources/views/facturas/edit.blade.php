<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Factura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Factura</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('facturas.update', $factura) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="correlativo" class="form-label">Correlativo *</label>
      <input type="number" name="correlativo" id="correlativo" class="form-control" value="{{ $factura->correlativo }}" required>
    </div>

    <div class="mb-3">
      <label for="letra_serie" class="form-label">Letra de Serie</label>
      <input type="text" name="letra_serie" id="letra_serie" class="form-control" value="{{ $factura->letra_serie }}" maxlength="1">
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha *</label>
      <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $factura->fecha }}" required>
    </div>

    <div class="mb-3">
      <label for="id_cliente" class="form-label">Cliente *</label>
      <select name="id_cliente" id="id_cliente" class="form-select" required>
        @foreach($clientes as $cliente)
          <option value="{{ $cliente->id }}" @if($factura->id_cliente == $cliente->id) selected @endif>{{ $cliente->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_empleado" class="form-label">Empleado *</label>
      <select name="id_empleado" id="id_empleado" class="form-select" required>
        @foreach($empleados as $empleado)
          <option value="{{ $empleado->id }}" @if($factura->id_empleado == $empleado->id) selected @endif>{{ $empleado->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_sucursal" class="form-label">Sucursal *</label>
      <select name="id_sucursal" id="id_sucursal" class="form-select" required>
        @foreach($sucursales as $sucursal)
          <option value="{{ $sucursal->id }}" @if($factura->id_sucursal == $sucursal->id) selected @endif>{{ $sucursal->nombre }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

</body>
</html>

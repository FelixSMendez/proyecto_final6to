<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nueva Factura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Registrar Factura</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('facturas.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="correlativo" class="form-label">Correlativo *</label>
      <input type="number" name="correlativo" id="correlativo" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="letra_serie" class="form-label">Letra de Serie</label>
      <input type="text" name="letra_serie" id="letra_serie" class="form-control" maxlength="1">
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha *</label>
      <input type="date" name="fecha" id="fecha" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="id_cliente" class="form-label">Cliente *</label>
      <select name="id_cliente" id="id_cliente" class="form-select" required>
        @foreach($clientes as $cliente)
          <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_empleado" class="form-label">Empleado *</label>
      <select name="id_empleado" id="id_empleado" class="form-select" required>
        @foreach($empleados as $empleado)
          <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="id_sucursal" class="form-label">Sucursal *</label>
      <select name="id_sucursal" id="id_sucursal" class="form-select" required>
        @foreach($sucursales as $sucursal)
          <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

</body>
</html>

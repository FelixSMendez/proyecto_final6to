<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo Pago</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Registrar Pago</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('pagos.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="id_factura" class="form-label">Factura *</label>
      <select name="id_factura" id="id_factura" class="form-select" required>
        <option value="">Seleccionar Factura</option>
        @foreach ($facturas as $factura)
          <option value="{{ $factura->id }}">{{ $factura->id }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="monto" class="form-label">Monto *</label>
      <input type="number" name="monto" id="monto" class="form-control" step="0.01" required>
    </div>

    <div class="mb-3">
      <label for="id_tipo_pago" class="form-label">Tipo de Pago</label>
      <select name="id_tipo_pago" id="id_tipo_pago" class="form-select">
        <option value="">Seleccionar Tipo de Pago</option>
        @foreach ($tipopagos as $tipopago)
          <option value="{{ $tipopago->id }}">{{ $tipopago->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="no_tarjeta" class="form-label">No. Tarjeta</label>
      <input type="text" name="no_tarjeta" id="no_tarjeta" class="form-control">
    </div>

    <div class="mb-3">
      <label for="no_cheque" class="form-label">No. Cheque</label>
      <input type="text" name="no_cheque" id="no_cheque" class="form-control">
    </div>

    <div class="mb-3">
      <label for="cambio" class="form-label">Cambio</label>
      <input type="number" name="cambio" id="cambio" class="form-control" step="0.01">
    </div>

    <div class="mb-3">
      <label for="fecha_expiracion" class="form-label">Fecha Expiración</label>
      <input type="date" name="fecha_expiracion" id="fecha_expiracion" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('pagos.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

</body>
</html>

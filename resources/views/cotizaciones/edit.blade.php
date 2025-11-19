<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Cotización</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Cotización</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('cotizaciones.update', $cotizacion) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="id_cliente" class="form-label">Cliente</label>
      <select name="id_cliente" id="id_cliente" class="form-select">
        <option value="">-- Seleccionar Cliente --</option>
        @foreach($clientes as $cliente)
          <option value="{{ $cliente->id }}" {{ $cotizacion->id_cliente == $cliente->id ? 'selected' : '' }}>
            {{ $cliente->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $cotizacion->fecha }}">
    </div>

    <div class="mb-3">
      <label for="total" class="form-label">Total</label>
      <input type="number" step="0.01" name="total" id="total" class="form-control" value="{{ $cotizacion->total }}">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

</body>
</html>

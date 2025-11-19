<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Carrito</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Carrito</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('carritos.update', $carrito) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="id_cliente" class="form-label">Cliente</label>
      <select name="id_cliente" id="id_cliente" class="form-select">
        <option value="">-- Seleccionar Cliente --</option>
        @foreach($clientes as $cliente)
          <option value="{{ $cliente->id }}" {{ $carrito->id_cliente == $cliente->id ? 'selected' : '' }}>
            {{ $cliente->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="fecha_creacion" class="form-label">Fecha Creación</label>
      <input type="date" name="fecha_creacion" id="fecha_creacion" class="form-control" value="{{ $carrito->fecha_creacion }}">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('carritos.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>

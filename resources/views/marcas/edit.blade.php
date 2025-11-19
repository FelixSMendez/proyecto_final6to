<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Marca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Marca</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('marcas.update', $marca) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre *</label>
      <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $marca->nombre }}" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control">{{ $marca->descripcion }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

</body>
</html>

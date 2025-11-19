<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Rol</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Editar Rol</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('roles.update', $rol) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="tipo" class="form-label">Tipo *</label>
      <input type="text" name="tipo" id="tipo" class="form-control" value="{{ $rol->tipo }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

</body>
</html>

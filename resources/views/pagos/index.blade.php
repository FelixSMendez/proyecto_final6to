<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Pagos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Pagos</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('pagos.create') }}" class="btn btn-primary mb-3">Nuevo Pago</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Factura</th>
        <th>Monto</th>
        <th>Tipo de Pago</th>
        <th>No. Tarjeta</th>
        <th>No. Cheque</th>
        <th>Cambio</th>
        <th>Fecha Expiración</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pagos as $pago)
        <tr>
          <td>{{ $pago->id_pago }}</td>
          <td>{{ $pago->factura->id ?? 'N/A' }}</td>
          <td>{{ $pago->monto }}</td>
          <td>{{ $pago->tipopago->nombre ?? 'N/A' }}</td>
          <td>{{ $pago->no_tarjeta }}</td>
          <td>{{ $pago->no_cheque }}</td>
          <td>{{ $pago->cambio }}</td>
          <td>{{ $pago->fecha_expiracion }}</td>
          <td>
            <a href="{{ route('pagos.edit', $pago->id_pago) }}" class="btn btn-warning btn-sm">Editar</a>
            <form action="{{ route('pagos.destroy', $pago->id_pago) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este pago?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

</body>
</html>

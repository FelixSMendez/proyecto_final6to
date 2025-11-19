<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h1 class="mb-4">Productos</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Nuevo Producto</a>
  <a href="/" class="btn btn-warning mb-3">Regresar</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Stock</th>
        <th>Tipo Producto</th>
        <th>Proveedor</th>
        <th>Detalle</th>
        <th>Precio</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($productos as $producto)
        <tr>
          <td>{{ $producto->id }}</td>
          <td>{{ $producto->nombre }}</td>
          <td>{{ $producto->stock }}</td>
          <td>{{ $producto->tipoProducto?->nombre }}</td>
          <td>{{ $producto->proveedor?->nombre }}</td>
          <td>
            @if($producto->detalleProducto)
              Color: {{ $producto->detalleProducto->color }}<br>
              Descripción: {{ $producto->detalleProducto->descripcion }}
            @endif
          </td>
          <td>
            @if($producto->precio)
              {{ $producto->precio->precioVenta }}
            @endif
          </td>
          <td>
            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
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

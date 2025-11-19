<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            color: #fff;
            padding: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 30px;
        }
        .card-title {
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="mb-4">Menú Administrativo</h3>
        <a href="{{ route('clientes.index') }}">Clientes</a>
        <a href="{{ route('empleados.index') }}">Empleados</a>
        <a href="{{ route('proveedores.index') }}">Proveedores</a>
        <a href="{{ route('sucursales.index') }}">Sucursales</a>
        <a href="{{ route('productos.index') }}">Productos</a>
        <a href="{{ route('tiposproductos.index') }}">Tipos de Productos</a>
        <a href="{{ route('marcas.index') }}">Marcas</a>
        <a href="{{ route('precios.index') }}">Precios</a>
        <a href="{{ route('lotes.index') }}">Lotes</a>
        <a href="{{ route('inventario.index') }}">Inventario</a>
        <a href="{{ route('tipopagos.index') }}">Tipos de Pago</a>
        <a href="{{ route('pagos.index') }}">Pagos</a>
        <a href="{{ route('facturas.index') }}">Facturas</a>
        <a href="{{ route('detallefacturas.index') }}">Detalle Facturas</a>
        <a href="{{ route('cotizaciones.index') }}">Cotizaciones</a>
        <a href="{{ route('detallecotizaciones.index') }}">Detalle Cotizaciones</a>
        <a href="{{ route('carritos.index') }}">Carritos</a>
        <a href="{{ route('detallecarritos.index') }}">Detalle Carritos</a>
        <a href="{{ route('usuariosistema.index') }}">Usuarios</a>
        <a href="{{ route('roles.index') }}">Roles</a>
        <a href="{{ route('tipomedidas.index') }}">Tipos de Medida</a>
        <a href="{{ route('detalleproductos.index') }}">Detalle Productos</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1 class="mb-4">Bienvenido al Panel Administrativo</h1>
        <p>Selecciona un módulo del menú lateral para administrar los datos de tu sistema. Aquí tienes un resumen de cada módulo:</p>

        <div class="row g-3 mt-3">

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Clientes</h5>
                        <p class="card-text">Gestiona clientes: agregar, editar, eliminar y ver detalles de los clientes registrados.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Empleados</h5>
                        <p class="card-text">Administra información de los empleados y sus roles dentro del sistema.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Proveedores</h5>
                        <p class="card-text">Agrega, edita o elimina proveedores y mantén sus datos actualizados.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Sucursales</h5>
                        <p class="card-text">Administra la información de las sucursales de la empresa.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Productos</h5>
                        <p class="card-text">Gestiona los productos que vendes y sus detalles generales.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Tipos de Productos</h5>
                        <p class="card-text">Define y administra categorías o tipos de productos disponibles.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Marcas</h5>
                        <p class="card-text">Agrega y gestiona marcas de productos para identificar proveedores o fabricantes.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Precios</h5>
                        <p class="card-text">Define los precios de los productos y administra cambios de costo.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Lotes</h5>
                        <p class="card-text">Controla los lotes de productos para gestionar inventario y fechas de caducidad.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Inventario</h5>
                        <p class="card-text">Consulta y administra el inventario general de productos por sucursal y lote.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Tipos de Pago</h5>
                        <p class="card-text">Configura los métodos de pago disponibles para facturas y cotizaciones.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Pagos</h5>
                        <p class="card-text">Registra y gestiona los pagos realizados por clientes en el sistema.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Facturas</h5>
                        <p class="card-text">Genera y administra facturas de ventas para los clientes.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Detalle Facturas</h5>
                        <p class="card-text">Gestiona el detalle de los productos vendidos en cada factura.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Cotizaciones</h5>
                        <p class="card-text">Crea cotizaciones para clientes y gestiona sus datos generales.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Detalle Cotizaciones</h5>
                        <p class="card-text">Administra el detalle de los productos incluidos en cada cotización.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Carritos</h5>
                        <p class="card-text">Gestiona los carritos de clientes para compras en curso.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Detalle Carritos</h5>
                        <p class="card-text">Administra los productos dentro de cada carrito de cliente.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text">Gestiona usuarios del sistema y controla su acceso.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Roles</h5>
                        <p class="card-text">Define y administra roles para controlar permisos y accesos de los usuarios.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Tipos de Medida</h5>
                        <p class="card-text">Configura las unidades de medida que se usarán en productos y lotes.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Detalle Productos</h5>
                        <p class="card-text">Administra información adicional de cada producto, como características y atributos.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\GerenceController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\TipoProductoController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\TipoMedidaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\DetalleProductoController;
use App\Http\Controllers\TipoPagoController;
use App\Http\Controllers\UsuarioSistemaController;
use App\Http\Controllers\UsuarioClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\SucursalGpsController;
use App\Http\Controllers\PrecioController;

// ====================================
// RUTAS CATÁLOGO PÚBLICO (SIN AUTH)
// ====================================
Route::get('/', [ProductoController::class, 'index'])->name('home');
Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo.index');
Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('catalogo.show');
Route::post('/gps/sucursal-mas-cercana', [SucursalGpsController::class, 'sucursalMasCercana'])->name('gps.sucursalMasCercana');

// ====================================
// RUTAS CARRITO PÚBLICO
// ====================================
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/actualizar/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::post('/carrito/quitar/{id}', [CarritoController::class, 'quitar'])->name('carrito.quitar');
Route::post('/carrito/cambiar-sucursal/{id}', [CarritoController::class, 'cambiarSucursal'])->name('carrito.cambiar-sucursal');

// ====================================
// RUTAS LOGIN CLIENTE
// ====================================
Route::get('/cliente/login', [ClienteLoginController::class, 'create'])->name('cliente.login');
Route::post('/cliente/login', [ClienteLoginController::class, 'store'])->name('cliente.login.store');

// ====================================
// RUTAS CLIENTE AUTENTICADO (auth:cliente)
// ====================================
Route::middleware(['auth:cliente'])->group(function () {
    Route::get('/cliente/dashboard', fn() => view('cliente.dashboard'))->name('cliente.dashboard');
    Route::get('/cliente/carrito', [CarritoController::class, 'index'])->name('cliente.carrito');
    Route::get('/cliente/pedidos', fn() => view('cliente.pedidos'))->name('cliente.pedidos');
    
    // Cotizaciones
    Route::get('/cotizaciones', [App\Http\Controllers\CotizacionController::class, 'index'])->name('cotizacion.index');
    Route::post('/cotizaciones/crear', [App\Http\Controllers\CotizacionController::class, 'crear'])->name('cotizacion.crear');
    Route::get('/cotizaciones/{id}', [App\Http\Controllers\CotizacionController::class, 'show'])->name('cotizacion.show');
    Route::post('/cotizaciones/{id}/estado', [App\Http\Controllers\CotizacionController::class, 'cambiarEstado'])->name('cotizacion.estado');
    Route::get('/cotizaciones/{id}/pdf', [App\Http\Controllers\CotizacionController::class, 'descargarPDF'])->name('cotizacion.pdf');
    Route::delete('/cotizaciones/{id}', [App\Http\Controllers\CotizacionController::class, 'destroy'])->name('cotizacion.destroy');
    
    // Logout de cliente
    Route::post('/logout-cliente', [UsuarioClienteController::class, 'logoutCliente'])->name('logout.cliente');
    
    // Cambiar a login empleado
    Route::get('/cambiar-a-empleado', [UsuarioClienteController::class, 'cambiarAEmpleado'])->name('auth.cambiar_empleado');
});

// ====================================
// RUTAS FACTURACIÓN PÚBLICA
// ====================================
Route::post('/factura', [FacturaController::class, 'store'])->name('factura.store');
Route::get('/factura/{id}/pago', [FacturaController::class, 'showPago'])->name('factura.showPago');
Route::post('/factura/{id}/pago', [FacturaController::class, 'guardarPago'])->name('factura.guardarPago');
Route::get('/factura/{id}/confirmacion', [FacturaController::class, 'confirmacion'])->name('factura.confirmacion');

// PDF Públicos
Route::get('/pdf/factura/{id}/descargar', [App\Http\Controllers\PdfController::class, 'descargarFactura'])->name('pdf.factura.descargar');
Route::get('/pdf/factura/{id}/preview', [App\Http\Controllers\PdfController::class, 'previewFactura'])->name('pdf.factura.preview');
Route::get('/pdf/cotizacion/{id}/descargar', [App\Http\Controllers\PdfController::class, 'descargarCotizacion'])->name('pdf.cotizacion.descargar');
Route::get('/pdf/cotizacion/{id}/preview', [App\Http\Controllers\PdfController::class, 'previewCotizacion'])->name('pdf.cotizacion.preview');

// ====================================
// RUTAS EMPLEADOS (auth:employee) - PROTEGIDAS
// ====================================
Route::middleware(['auth:employee'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/dashboard/digitador', fn() => view('dashboard.digitador'))->name('dashboard.digitador');
    Route::get('/dashboard/cajero', fn() => view('dashboard.cajero'))->name('dashboard.cajero');
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Logout de empleado
    Route::post('/logout-empleado', [UsuarioSistemaController::class, 'logoutEmpleado'])->name('logout.empleado');
    
    // Cambiar a login cliente
    Route::get('/cambiar-a-cliente', [UsuarioSistemaController::class, 'cambiarACliente'])->name('auth.cambiar_cliente');
    
    // ====================================
    // LOTES (Digitador)
    // ====================================
    Route::prefix('almacen')->group(function () {
        Route::get('/lotes', [LoteController::class, 'index'])->name('almacen.lotes.index');
        Route::get('/lotes/crear', [LoteController::class, 'create'])->name('almacen.lotes.create');
        Route::post('/lotes', [LoteController::class, 'store'])->name('almacen.lotes.store');
        Route::get('/lotes/{id}', [LoteController::class, 'show'])->name('almacen.lotes.show');
    });
    
    // ====================================
    // FACTURACIÓN TIENDA (Solo Cajero)
    // ====================================
    Route::middleware('es_cajero')->group(function () {
        Route::get('/factura/tienda/crear', [FacturaController::class, 'createTienda'])->name('factura.tienda.create');
        Route::post('/factura/tienda', [FacturaController::class, 'storeTienda'])->name('factura.tienda.store');
    });
    
    // ====================================
    // CRUD PRODUCTOS (Admin)
    // ====================================
    Route::controller(ProductoController::class)->prefix('admin')->group(function () {
        Route::get('/productos', 'indice')->name('productos.index');
        Route::get('/productos/create', 'create')->name('productos.create');
        Route::post('/productos', 'store')->name('productos.store');
        Route::get('/productos/{producto}/edit', 'edit')->name('productos.edit');
        Route::put('/productos/{producto}', 'update')->name('productos.update');
        Route::delete('/productos/{producto}', 'destroy')->name('productos.destroy');
    });
    
    // ====================================
    // OTROS CRUDS (Admin)
    // ====================================
    Route::prefix('admin')->group(function () {
        Route::resource('tipoproductos', TipoProductoController::class);
        Route::resource('marcas', MarcasController::class);
        Route::resource('tipomedidas', TipoMedidaController::class);
        Route::resource('proveedores', ProveedorController::class);
        Route::resource('clientes', ClienteController::class);
        Route::resource('sucursales', SucursalController::class);
        Route::resource('detalleproductos', DetalleProductoController::class);
        Route::resource('tipopagos', TipoPagoController::class);
        Route::resource('usuariosistema', UsuarioSistemaController::class);
        Route::resource('usuariocliente', UsuarioClienteController::class);
        Route::resource('precios', PrecioController::class);
    });
    
    // ====================================
    // REPORTES GERENTE
    // ====================================
    Route::prefix('gerente')->group(function () {
        Route::get('/dashboard', [GerenceController::class, 'dashboard'])->name('gerente.dashboard');
        Route::get('/reporte-monto', [GerenceController::class, 'reporteMonto'])->name('gerente.reporte-monto');
        Route::get('/reporte-ingresos', [GerenceController::class, 'reporteIngresos'])->name('gerente.reporte-ingresos');
        Route::get('/reporte-vendidos', [GerenceController::class, 'reporteVendidos'])->name('gerente.reporte-vendidos');
        Route::get('/reporte-inventario', [GerenceController::class, 'reporteInventario'])->name('gerente.reporte-inventario');
        Route::get('/reporte-menos-vendidos', [GerenceController::class, 'reporteMenosVendidos'])->name('gerente.reporte-menos-vendidos');
        Route::get('/reporte-sin-stock', [GerenceController::class, 'reporteSinStock'])->name('gerente.reporte-sin-stock');
        Route::get('/reporte-buscar-factura', [GerenceController::class, 'reporteBuscarFactura'])->name('gerente.reporte-buscar-factura');
        Route::get('/reporte-ingresos-inv', [GerenceController::class, 'reporteIngresosInv'])->name('gerente.reporte-ingresos-inv');
        Route::get('/reporte-stock-minimo', [GerenceController::class, 'reporteStockMinimo'])->name('gerente.reporte-stock-minimo');
        Route::get('/reporte-inventario-tienda/{id?}', [GerenceController::class, 'reporteInventarioTienda'])->name('gerente.reporte-inventario-tienda');
        Route::resource('empleados', EmpleadoController::class);
        // Anulación de facturas
        Route::get('/facturas-anular', [GerenceController::class, 'facturasAnular'])->name('gerente.facturas-anular');
        Route::get('/factura/{id}/anular', [GerenceController::class, 'mostrarFacturaAnular'])->name('gerente.factura-anular-detalle');
        Route::post('/factura/{id}/anular', [GerenceController::class, 'anularFactura'])->name('gerente.factura-anular-guardar');
    });
});

// ====================================
// AUTH ROUTES (Breeze) - Login/Logout Empleados
// ====================================
require __DIR__.'/auth.php';
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
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TipoMedidaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\DetalleProductoController;
use App\Http\Controllers\TipoPagoController;
use App\Http\Controllers\UsuarioSistemaController;

Route::get('/', [App\Http\Controllers\ProductoController::class, 'index'])->name('home');

// ====================================
// RUTAS CATÁLOGO PÚBLICO
// ====================================
Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo.index');
Route::get('/catalogo/producto/{id}', [App\Http\Controllers\ProductoController::class, 'show'])->name('catalogo.show');

// ====================================
// RUTAS CARRITO
// ====================================
Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar/{id}', [App\Http\Controllers\CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/actualizar/{id}', [App\Http\Controllers\CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::post('/carrito/quitar/{id}', [App\Http\Controllers\CarritoController::class, 'quitar'])->name('carrito.quitar');
Route::post('/carrito/cambiar-sucursal/{id}', [App\Http\Controllers\CarritoController::class, 'cambiarSucursal'])
    ->name('carrito.cambiar-sucursal');

Route::get('/factura/{id}/pago', [FacturaController::class, 'showPago'])->name('factura.showPago');
Route::post('/factura/{id}/pago', [FacturaController::class, 'procesarPago'])->name('factura.procesarPago');

// ====================================
// RUTAS PARA CLIENTES (usuariosclientes)
// ====================================
Route::get('/cliente/login', [ClienteLoginController::class, 'create'])->name('cliente.login');
Route::post('/cliente/login', [ClienteLoginController::class, 'store'])->name('cliente.login.store');

Route::middleware(['auth:cliente'])->group(function () {
    Route::get('/cliente/dashboard', fn() => view('cliente.dashboard'))->name('cliente.dashboard');
    Route::post('/cliente/logout', [ClienteLoginController::class, 'destroy'])->name('cliente.logout');
    Route::get('/cliente/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('cliente.carrito');
    Route::get('/cliente/pedidos', fn() => view('cliente.pedidos'))->name('cliente.pedidos');
});

// ====================================
// FACTURACIÓN - CLIENTE WEB (Sin auth)
// ====================================
Route::post('/factura', [FacturaController::class, 'store'])->name('factura.store');
Route::get('/factura/{id}/pago', [FacturaController::class, 'showPago'])->name('factura.showPago');
Route::post('/factura/{id}/pago', [FacturaController::class, 'guardarPago'])->name('factura.guardarPago');
Route::get('/factura/{id}/confirmacion', [FacturaController::class, 'confirmacion'])->name('factura.confirmacion');

//  RUTAS PÚBLICAS - Cualquiera puede descargar facturas y cotizaciones
Route::get('/pdf/factura/{id}/descargar', [App\Http\Controllers\PdfController::class, 'descargarFactura'])->name('pdf.factura.descargar');
Route::get('/pdf/factura/{id}/preview', [App\Http\Controllers\PdfController::class, 'previewFactura'])->name('pdf.factura.preview');
Route::get('/pdf/cotizacion/{id}/descargar', [App\Http\Controllers\PdfController::class, 'descargarCotizacion'])->name('pdf.cotizacion.descargar');
Route::get('/pdf/cotizacion/{id}/preview', [App\Http\Controllers\PdfController::class, 'previewCotizacion'])->name('pdf.cotizacion.preview');

// ====================================
// RUTAS PARA DIGITADOR - INGRESO DE LOTES
// ====================================
Route::middleware(['auth:employee'])->prefix('almacen')->group(function () {
    Route::get('/lotes', [LoteController::class, 'index'])->name('almacen.lotes.index');
    Route::get('/lotes/crear', [LoteController::class, 'create'])->name('almacen.lotes.create');
    Route::post('/lotes', [LoteController::class, 'store'])->name('almacen.lotes.store');
    Route::get('/lotes/{id}', [LoteController::class, 'show'])->name('almacen.lotes.show');
});



// ====================================
// RUTAS PARA EMPLEADOS (usuariosistema)
// ====================================
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/dashboard/digitador', fn() => view('dashboard.digitador'))->name('dashboard.digitador');
    Route::get('/dashboard/cajero', fn() => view('dashboard.cajero'))->name('dashboard.cajero');
    //Route::middleware('es_gerente')->get('/dashboard/gerente', [GerenceController::class, 'dashboard'])->name('dashboard.gerente');

    // Solo cajeros
    Route::middleware('es_cajero')->group(function () {
        Route::get('/factura/tienda/crear', [FacturaController::class, 'createTienda'])->name('factura.tienda.create');
        Route::post('/factura/tienda', [FacturaController::class, 'storeTienda'])->name('factura.tienda.store');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//  RUTAS COTIZACIONES
Route::middleware('auth:cliente')->group(function () {
    Route::get('/cotizaciones', [App\Http\Controllers\CotizacionController::class, 'index'])->name('cotizacion.index');
    Route::post('/cotizaciones/crear', [App\Http\Controllers\CotizacionController::class, 'crear'])->name('cotizacion.crear');
    Route::get('/cotizaciones/{id}', [App\Http\Controllers\CotizacionController::class, 'show'])->name('cotizacion.show');
    Route::post('/cotizaciones/{id}/estado', [App\Http\Controllers\CotizacionController::class, 'cambiarEstado'])->name('cotizacion.estado');
    Route::get('/cotizaciones/{id}/pdf', [App\Http\Controllers\CotizacionController::class, 'descargarPDF'])->name('cotizacion.pdf');
    Route::delete('/cotizaciones/{id}', [App\Http\Controllers\CotizacionController::class, 'destroy'])->name('cotizacion.destroy');
});

//Reportes para gerente
Route::middleware(['auth:employee'])->prefix('gerente')->group(function () {
    // Dashboard
    Route::get('/dashboard', [GerenceController::class, 'dashboard'])->name('gerente.dashboard');
    
    // Reportes (retorna vistas)
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
    
    // Anulación de facturas
    Route::get('/facturas-anular', [GerenceController::class, 'facturasAnular'])->name('gerente.facturas-anular');
    Route::get('/factura/{id}/anular', [GerenceController::class, 'mostrarFacturaAnular'])->name('gerente.factura-anular-detalle');
    Route::post('/factura/{id}/anular', [GerenceController::class, 'anularFactura'])->name('gerente.factura-anular-guardar');
});

Route::controller(ProductoController::class)->group(function () {
    Route::get('/productos', 'indice')->name('productos.index');
    Route::get('/productos/create', 'create')->name('productos.create');
    Route::post('/productos', 'store')->name('productos.store');
    Route::get('/productos/{producto}/edit', 'edit')->name('productos.edit');
    Route::put('/productos/{producto}', 'update')->name('productos.update');
    Route::delete('/productos/{producto}', 'destroy')->name('productos.destroy');
});
Route::resource('tipoproductos', TipoProductoController::class);
Route::resource('marcas', MarcasController::class);
Route::resource('tipomedidas', TipoMedidaController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('sucursales', SucursalController::class);
Route::resource('detalleproductos', DetalleProductoController::class);
Route::resource('tipopagos', TipoPagoController::class);
Route::resource('usuariosistema', UsuarioSistemaController::class);
// ====================================
// AUTH ROUTES (Breeze) - Login/Logout Empleados
// ====================================
require __DIR__.'/auth.php';

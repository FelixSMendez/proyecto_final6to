<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\FacturaController;

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


// ====================================
// RUTAS PARA EMPLEADOS (usuariosistema)
// ====================================
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/dashboard/digitador', fn() => view('dashboard.digitador'))->name('dashboard.digitador');
    Route::get('/dashboard/cajero', fn() => view('dashboard.cajero'))->name('dashboard.cajero');
    Route::get('/dashboard/gerente', fn() => view('dashboard.gerente'))->name('dashboard.gerente');

    // Solo cajeros
    Route::middleware('es_cajero')->group(function () {
        Route::get('/factura/tienda/crear', [FacturaController::class, 'createTienda'])->name('factura.tienda.create');
        Route::post('/factura/tienda', [FacturaController::class, 'storeTienda'])->name('factura.tienda.store');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================================
// AUTH ROUTES (Breeze) - Login/Logout Empleados
// ====================================
require __DIR__.'/auth.php';

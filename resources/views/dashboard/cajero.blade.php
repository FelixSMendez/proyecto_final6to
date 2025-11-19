@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-cash-register me-2"></i> Panel Cajero - Punto de Venta
            </h1>
            <p class="text-muted small">Procesar ventas, cobros y gestionar facturas</p>
        </div>
        <div class="col-md-4 text-end">
            <span class="badge bg-success">{{ auth()->user()->empleado->nombre ?? 'Usuario' }}</span>
            <span class="badge bg-secondary">{{ auth()->user()->getTipoRolAttribute() }}</span>
        </div>
    </div>

    <!-- KPIs de Ventas del Día -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body">
                    <div class="text-success font-weight-bold text-uppercase small">Facturas Hoy</div>
                    <div class="h3 mb-0">0</div>
                    <p class="small text-muted mt-2">Emitidas por ti</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="text-primary font-weight-bold text-uppercase small">Monto Vendido</div>
                    <div class="h3 mb-0">Q 0.00</div>
                    <p class="small text-muted mt-2">Total de ventas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="text-warning font-weight-bold text-uppercase small">Efectivo Recibido</div>
                    <div class="h3 mb-0">Q 0.00</div>
                    <p class="small text-muted mt-2">Pagos en efectivo</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow-sm h-100">
                <div class="card-body">
                    <div class="text-info font-weight-bold text-uppercase small">Transacciones</div>
                    <div class="h3 mb-0">0</div>
                    <p class="small text-muted mt-2">Medios de pago</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú Principal de Ventas -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h5 class="mb-3">
                <i class="fas fa-shopping-cart me-2"></i> Operaciones de Venta
            </h5>
        </div>
    </div>

    <div class="row">
        <!-- Catálogo de Productos -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-book-open fa-3x text-primary mb-3"></i>
                    <h6 class="card-title">Ver Catálogo</h6>
                    <p class="card-text small text-muted">Buscar productos por tipo, marca, medida</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Lectura</small>
                </div>
            </a>
        </div>

        <!-- Nuevo Carrito -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-cart-plus fa-3x text-success mb-3"></i>
                    <h6 class="card-title">Nuevo Carrito</h6>
                    <p class="card-text small text-muted">Crear carrito y agregar productos a vender</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Crear/Modificar</small>
                </div>
            </a>
        </div>

        <!-- Ver Mi Carrito Actual -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-bag fa-3x text-warning mb-3"></i>
                    <h6 class="card-title">Mi Carrito</h6>
                    <p class="card-text small text-muted">Ver, modificar cantidades y aplicar descuentos</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Modificar</small>
                </div>
            </a>
        </div>

        <!-- Crear Factura -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-file-invoice fa-3x text-info mb-3"></i>
                    <h6 class="card-title">Generar Factura</h6>
                    <p class="card-text small text-muted">Procesar venta y generar factura correlativa</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Crear</small>
                </div>
            </a>
        </div>

        <!-- Registrar Pagos -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-credit-card fa-3x text-secondary mb-3"></i>
                    <h6 class="card-title">Medios de Pago</h6>
                    <p class="card-text small text-muted">Efectivo, Cheque, Tarjeta Débito/Crédito</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Registrar</small>
                </div>
            </a>
        </div>

        <!-- Mis Facturas -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-receipt fa-3x text-dark mb-3"></i>
                    <h6 class="card-title">Mis Facturas</h6>
                    <p class="card-text small text-muted">Historial de facturas que has emitido</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Lectura</small>
                </div>
            </a>
        </div>

        <!-- Clientes -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-user-check fa-3x text-primary mb-3"></i>
                    <h6 class="card-title">Buscar Cliente</h6>
                    <p class="card-text small text-muted">Buscar cliente registrado o crear nuevo</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Lectura</small>
                </div>
            </a>
        </div>

        <!-- Cotizaciones -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-file-alt fa-3x text-info mb-3"></i>
                    <h6 class="card-title">Generar Cotización</h6>
                    <p class="card-text small text-muted">Crear cotización en PDF para presentar</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Crear</small>
                </div>
            </a>
        </div>

        <!-- Consultar Stock -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-search fa-3x text-warning mb-3"></i>
                    <h6 class="card-title">Consultar Stock</h6>
                    <p class="card-text small text-muted">Verificar disponibilidad antes de vender</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Lectura</small>
                </div>
            </a>
        </div>
    </div>

    <!-- Restricciones -->
    <div class="alert alert-warning mt-4">
        <h6 class="alert-heading">
            <i class="fas fa-ban me-2"></i> Restricciones de Acceso
        </h6>
        <ul class="mb-0">
            <li>❌ NO puedes crear ni modificar productos (solo Digitador)</li>
            <li>❌ NO puedes ver reportes ni estadísticas (solo Gerente)</li>
            <li>❌ NO puedes anular facturas (solo Gerente)</li>
            <li>✅ Puedes vender, cobrar y procesar todas las operaciones de venta</li>
            <li>⚠️ Solo ves tus propias facturas y transacciones</li>
        </ul>
    </div>
</div>

<style>
    .border-left-success { border-left: 4px solid #28a745 !important; }
    .border-left-primary { border-left: 4px solid #007bff !important; }
    .border-left-warning { border-left: 4px solid #ffc107 !important; }
    .border-left-info { border-left: 4px solid #17a2b8 !important; }
    .transition {
        transition: all 0.3s ease;
    }
    .transition:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4"> 
    <!-- Header --> 
     <div class="row mb-4"> 
        <div class="col-md-8"> 
            <h1 class="h3 mb-0"> <i class="fas fa-cash-register me-2"></i> Punto de Venta </h1> 
            <p class="text-muted small">Procesa ventas y autoriza cobros</p> 
        </div> 
        <div class="col-md-4 text-end"> 
            <span class="badge bg-success">{{ auth('employee')->user()->usuario }}</span> 
            <span class="badge bg-secondary">Cajero</span> 
        </div> 
    </div>

<!-- KPIs Rápidos del Día -->
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

<!-- Menú Principal - Solo lo necesario -->
<div class="row mb-4">
    <div class="col-md-12">
        <h5 class="mb-3">
            <i class="fas fa-shopping-cart me-2"></i> Operaciones
        </h5>
    </div>
</div>

<div class="row">
    <!-- Ver Catálogo -->
    <div class="col-md-4 mb-3">
        <a href="{{ route('catalogo.index') }}" class="card text-decoration-none border-0 shadow-sm h-100 transition">
            <div class="card-body text-center">
                <i class="fas fa-book-open fa-3x text-primary mb-3"></i>
                <h6 class="card-title">Catálogo</h6>
                <p class="card-text small text-muted">Buscar y consultar productos disponibles</p>
                <small class="text-success font-weight-bold">✓ Ver productos</small>
            </div>
        </a>
    </div>

    <!-- Mi Carrito de Ventas -->
    <div class="col-md-4 mb-3">
        <a href="{{ route('carrito.index') }}" class="card text-decoration-none border-0 shadow-sm h-100 transition">
            <div class="card-body text-center">
                <i class="fas fa-shopping-bag fa-3x text-warning mb-3"></i>
                <h6 class="card-title">Mi Carrito</h6>
                <p class="card-text small text-muted">Productos a vender - Procesar pago</p>
                <small class="text-success font-weight-bold">✓ Gestionar y cobrar</small>
            </div>
        </a>
    </div>

    <!-- Historial de Facturas -->
    <div class="col-md-4 mb-3">
        <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
            <div class="card-body text-center">
                <i class="fas fa-receipt fa-3x text-dark mb-3"></i>
                <h6 class="card-title">Mis Facturas</h6>
                <p class="card-text small text-muted">Historial de ventas realizadas hoy</p>
                <small class="text-success font-weight-bold">✓ Ver registro</small>
            </div>
        </a>
    </div>
</div>

<!-- Flujo Recomendado -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-arrow-right me-2"></i> Flujo de Venta
    </h6>
    <ol class="mb-0">
        <li><strong>1. Ver Catálogo:</strong> Explora los productos disponibles por categoría, marca o medida</li>
        <li><strong>2. Mi Carrito:</strong> Agrega productos al carrito desde el catálogo</li>
        <li><strong>3. Procesar Pago:</strong> Desde el carrito, inicia el proceso de facturación y cobro</li>
        <li><strong>4. Autorizar Venta:</strong> Se genera la factura correlativa con todos los detalles</li>
        <li><strong>5. Registrar Pagos:</strong> Ingresa el medio de pago (efectivo, cheque, tarjeta)</li>
    </ol>
</div>

<!-- Restricciones -->
<div class="alert alert-warning">
    <h6 class="alert-heading">
        <i class="fas fa-lock me-2"></i> Permisos y Restricciones
    </h6>
    <ul class="mb-0 small">
        <li>✅ Consultar catálogo de productos</li>
        <li>✅ Crear carrito de ventas</li>
        <li>✅ Agregar/modificar productos en carrito</li>
        <li>✅ Generar facturas (correlativo automático)</li>
        <li>✅ Registrar cobros en múltiples medios</li>
        <li>✅ Ver historial de tus facturas</li>
        <li>❌ Modificar precios de productos</li>
        <li>❌ Crear/editar productos</li>
        <li>❌ Ver reportes ni estadísticas</li>
        <li>❌ Anular o modificar facturas emitidas</li>
    </ul>
</div>
</div> 
<style> 
.border-left-success 
{ 
    border-left: 4px solid #28a745 !important; 
} 
.border-left-primary 
{ 
    border-left: 4px solid #007bff !important; 
} 
.border-left-warning { 
    border-left: 4px solid #ffc107 !important; 
} 
.border-left-info 
{ 
    border-left: 4px solid #17a2b8 !important; 
} 
.transition { 
    transition: all 0.3s ease; 
} 
.transition:hover 
{ 
    transform: translateY(-5px); 
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; 
} 
</style>
@endsection
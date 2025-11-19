@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-database me-2"></i> Panel Digitador - Gestión de Datos
            </h1>
            <p class="text-muted small">Alimentar el sistema: productos, proveedores e inventario</p>
        </div>
        <div class="col-md-4 text-end">
            <span class="badge bg-info">{{ auth()->user()->empleado->nombre ?? 'Usuario' }}</span>
            <span class="badge bg-secondary">{{ auth()->user()->getTipoRolAttribute() }}</span>
        </div>
    </div>

    <!-- Estadísticas de Datos -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="text-primary font-weight-bold text-uppercase small">Productos</div>
                    <div class="h3 mb-0">{{ \App\Models\Producto::count() }}</div>
                    <p class="small text-muted mt-2">En catálogo</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body">
                    <div class="text-success font-weight-bold text-uppercase small">Proveedores</div>
                    <div class="h3 mb-0">{{ \App\Models\Proveedor::count() }}</div>
                    <p class="small text-muted mt-2">Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="text-warning font-weight-bold text-uppercase small">Lotes Ingresados</div>
                    <div class="h3 mb-0">{{ \App\Models\Lote::count() }}</div>
                    <p class="small text-muted mt-2">Este mes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow-sm h-100">
                <div class="card-body">
                    <div class="text-info font-weight-bold text-uppercase small">Clientes</div>
                    <div class="h3 mb-0">{{ \App\Models\Cliente::count() }}</div>
                    <p class="small text-muted mt-2">Registrados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú de Acciones Principales -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h5 class="mb-3">
                <i class="fas fa-tools me-2"></i> Gestión del Sistema
            </h5>
        </div>
    </div>

    <div class="row">
        <!-- Gestión de Productos -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-3x text-primary mb-3"></i>
                    <h6 class="card-title">Productos</h6>
                    <p class="card-text small text-muted">CRUD: crear, modificar, eliminar productos</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Tipos de Productos -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-list fa-3x text-info mb-3"></i>
                    <h6 class="card-title">Tipos de Productos</h6>
                    <p class="card-text small text-muted">Pinturas, Solventes, Accesorios, Barnices</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Marcas -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-tag fa-3x text-warning mb-3"></i>
                    <h6 class="card-title">Marcas</h6>
                    <p class="card-text small text-muted">Gestionar marcas: Sherwin, Devco, Sáenz, etc.</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Medidas -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-ruler-vertical fa-3x text-secondary mb-3"></i>
                    <h6 class="card-title">Tipos de Medida</h6>
                    <p class="card-text small text-muted">1/32, 1/16, 1/8, 1/4, 1/2, 1 galón, cubeta</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Proveedores -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-3x text-dark mb-3"></i>
                    <h6 class="card-title">Proveedores</h6>
                    <p class="card-text small text-muted">Gestionar datos de proveedores, contactos</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Ingreso de Lotes -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-dolly fa-3x text-success mb-3"></i>
                    <h6 class="card-title">Ingreso de Lotes</h6>
                    <p class="card-text small text-muted">Registrar ingresos de inventario con proveedor</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Clientes -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h6 class="card-title">Clientes</h6>
                    <p class="card-text small text-muted">Registrar clientes, contactos, preferencias</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Sucursales -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-store fa-3x text-info mb-3"></i>
                    <h6 class="card-title">Sucursales</h6>
                    <p class="card-text small text-muted">Gestionar ubicaciones y datos de tiendas</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Inventario por Sucursal -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-warehouse fa-3x text-warning mb-3"></i>
                    <h6 class="card-title">Inventario</h6>
                    <p class="card-text small text-muted">Ver stock por producto y sucursal</p>
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
            <li>❌ NO puedes acceder a facturación ni ventas (únicamente para Cajero)</li>
            <li>❌ NO puedes ver reportes (únicamente para Gerente)</li>
            <li>❌ NO puedes procesar pagos ni cobros</li>
            <li>✅ Puedes crear, modificar y ver todo relacionado con datos maestros</li>
        </ul>
    </div>
</div>

<style>
    .border-left-primary { border-left: 4px solid #007bff !important; }
    .border-left-success { border-left: 4px solid #28a745 !important; }
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
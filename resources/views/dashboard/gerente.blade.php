@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-chart-line me-2"></i> Panel Gerente - Reportes y Control
            </h1>
            <p class="text-muted small">Análisis, estadísticas y toma de decisiones</p>
        </div>
        <div class="col-md-4 text-end">
            <span class="badge bg-danger">{{ auth()->user()->empleado->nombre ?? 'Usuario' }}</span>
            <span class="badge bg-secondary">{{ auth()->user()->getTipoRolAttribute() }}</span>
        </div>
    </div>

    <!-- KPIs Generales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="text-primary font-weight-bold text-uppercase small">Total Ventas</div>
                    <div class="h3 mb-0">Q 0.00</div>
                    <p class="small text-muted mt-2">Este mes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body">
                    <div class="text-success font-weight-bold text-uppercase small">Productos</div>
                    <div class="h3 mb-0">{{ \App\Models\Producto::count() }}</div>
                    <p class="small text-muted mt-2">En catálogo</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="text-warning font-weight-bold text-uppercase small">Sucursales</div>
                    <div class="h3 mb-0">{{ \App\Models\Sucursal::count() }}</div>
                    <p class="small text-muted mt-2">Activas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow-sm h-100">
                <div class="card-body">
                    <div class="text-info font-weight-bold text-uppercase small">Empleados</div>
                    <div class="h3 mb-0">{{ \App\Models\Empleado::count() }}</div>
                    <p class="small text-muted mt-2">En sistema</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reportes Disponibles -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h5 class="mb-3">
                <i class="fas fa-file-alt me-2"></i> Reportes (10 Reportes Requeridos)
            </h5>
        </div>
    </div>

    <div class="row">
        <!-- REPORTE 1: Facturación Total -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-3x text-primary mb-3"></i>
                    <h6 class="card-title">Reporte 1: Facturación Total</h6>
                    <p class="card-text small text-muted">Monto facturado entre fechas por medio de pago</p>
                    <small class="font-weight-bold">Efectivo | Cheque | Tarjeta</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 2: Productos Más Dinero -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                    <h6 class="card-title">Reporte 2: Productos Más Dinero</h6>
                    <p class="card-text small text-muted">Entre fechas: Ingresos generados por producto</p>
                    <small class="font-weight-bold">Monto Q / Producto</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 3: Productos Más Vendidos -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-3x text-info mb-3"></i>
                    <h6 class="card-title">Reporte 3: Productos Más Vendidos</h6>
                    <p class="card-text small text-muted">Cantidad de unidades vendidas por producto</p>
                    <small class="font-weight-bold">Galones | Cubetas | Unidades</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 4: Inventario General -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-warehouse fa-3x text-warning mb-3"></i>
                    <h6 class="card-title">Reporte 4: Inventario General</h6>
                    <p class="card-text small text-muted">Stock actual de todos los productos en todas las sucursales</p>
                    <small class="font-weight-bold">Stock Total</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 5: Inventario por Tienda -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-store fa-3x text-secondary mb-3"></i>
                    <h6 class="card-title">Reporte 5: Inventario por Tienda</h6>
                    <p class="card-text small text-muted">Stock desglosado por cada sucursal</p>
                    <small class="font-weight-bold">Pradera | Miraflores | Otros</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 6: Productos Menos Vendidos -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-down fa-3x text-danger mb-3"></i>
                    <h6 class="card-title">Reporte 6: Menos Vendidos</h6>
                    <p class="card-text small text-muted">Productos con baja rotación de ventas</p>
                    <small class="font-weight-bold">Análisis de Ventas</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 7: Productos Sin Stock -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <h6 class="card-title">Reporte 7: Sin Stock</h6>
                    <p class="card-text small text-muted">Productos agotados que necesitan reorden</p>
                    <small class="font-weight-bold">Stock = 0</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 8: Productos Bajo Mínimo -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-bell fa-3x text-warning mb-3"></i>
                    <h6 class="card-title">Reporte 8: Bajo Mínimo</h6>
                    <p class="card-text small text-muted">Productos con stock menor al mínimo permitido</p>
                    <small class="font-weight-bold">Alerta: Reabastecer</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 9: Detalle de Factura -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-search fa-3x text-info mb-3"></i>
                    <h6 class="card-title">Reporte 9: Detalle Factura</h6>
                    <p class="card-text small text-muted">Buscar factura por #serie/correlativo con detalles y medios de pago</p>
                    <small class="font-weight-bold">Número de Factura</small>
                </div>
            </a>
        </div>

        <!-- REPORTE 10: Ingresos de Inventario -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-3x text-primary mb-3"></i>
                    <h6 class="card-title">Reporte 10: Ingresos Inventario</h6>
                    <p class="card-text small text-muted">Historial de ingresos por proveedor, fecha, cantidad</p>
                    <small class="font-weight-bold">Reabastecimientos</small>
                </div>
            </a>
        </div>
    </div>

    <!-- Control Adicional -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h5 class="mb-3">
                <i class="fas fa-cog me-2"></i> Control y Administración
            </h5>
        </div>
    </div>

    <div class="row">
        <!-- Anular Factura -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h6 class="card-title">Anular Factura</h6>
                    <p class="card-text small text-muted">Anular por número de factura: reverso de transacción</p>
                    <small class="text-danger font-weight-bold">✓ Acceso: Solo Gerente</small>
                </div>
            </a>
        </div>

        <!-- Gestionar Empleados -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-users-cog fa-3x text-secondary mb-3"></i>
                    <h6 class="card-title">Gestionar Empleados</h6>
                    <p class="card-text small text-muted">ABM: crear, asignar roles, activar/desactivar</p>
                    <small class="text-success font-weight-bold">✓ Acceso: ABM Completo</small>
                </div>
            </a>
        </div>

        <!-- Auditoría y Logs -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-history fa-3x text-info mb-3"></i>
                    <h6 class="card-title">Auditoría</h6>
                    <p class="card-text small text-muted">Registro de quién hizo qué, cuándo y dónde</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Lectura</small>
                </div>
            </a>
        </div>

        <!-- Exportar Reportes -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-download fa-3x text-warning mb-3"></i>
                    <h6 class="card-title">Exportar Reportes</h6>
                    <p class="card-text small text-muted">Descargar cualquier reporte en XLS o PDF con logo</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Exportar</small>
                </div>
            </a>
        </div>

        <!-- Sistema de Backup -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-save fa-3x text-primary mb-3"></i>
                    <h6 class="card-title">Sistema de Backup</h6>
                    <p class="card-text small text-muted">Crear/restaurar backup completo de base de datos</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Solo Gerente</small>
                </div>
            </a>
        </div>

        <!-- Configuración Sistema -->
        <div class="col-md-4 mb-3">
            <a href="#" class="card text-decoration-none border-0 shadow-sm h-100 transition">
                <div class="card-body text-center">
                    <i class="fas fa-sliders-h fa-3x text-secondary mb-3"></i>
                    <h6 class="card-title">Configuración</h6>
                    <p class="card-text small text-muted">Parámetros del sistema, IVA, correlativas facturas</p>
                    <small class="text-success font-weight-bold">✓ Acceso: Modificar</small>
                </div>
            </a>
        </div>
    </div>

    <!-- Restricciones -->
    <div class="alert alert-info mt-4">
        <h6 class="alert-heading">
            <i class="fas fa-shield-alt me-2"></i> Permisos de Gerente
        </h6>
        <ul class="mb-0">
            <li>✅ Acceso TOTAL a todos los reportes del sistema (10 reportes)</li>
            <li>✅ Puedes anular facturas y hacer reversos de transacciones</li>
            <li>✅ Gestión de empleados y asignación de roles</li>
            <li>✅ Sistema de backup y recuperación</li>
            <li>✅ Exportar reportes en XLS y PDF</li>
            <li>❌ NO puedes vender directamente (es función del Cajero)</li>
            <li>❌ NO puedes crear productos (es función del Digitador)</li>
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
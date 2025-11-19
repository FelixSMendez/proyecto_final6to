@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">📊 Dashboard - {{ auth('employee')->user()->usuario }}</h2>

    <!-- Mostrar rol del usuario -->
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Rol:</strong> {{ ucfirst(auth('employee')->user()->rol) }}
    </div>

    <!-- SECCIÓN CAJERO - Solo visible para cajeros -->
    @if(auth('employee')->user()->rol === 'cajero')
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">💳 Panel de Cajero</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Gestiona las ventas en tienda y crea facturas</p>
                        
                        <a href="{{ route('factura.tienda.create') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-receipt me-2"></i> Crear Factura en Tienda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- SECCIÓN GERENTE - Solo visible para gerentes -->
    @if(auth('employee')->user()->rol === 'gerente')
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">📈 Panel de Gerente</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Acceso a reportes y gestión general</p>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <a href="#" class="btn btn-primary w-100">
                                    <i class="fas fa-chart-bar me-2"></i> Reportes
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-primary w-100">
                                    <i class="fas fa-users me-2"></i> Empleados
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-primary w-100">
                                    <i class="fas fa-box me-2"></i> Inventario
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-primary w-100">
                                    <i class="fas fa-cog me-2"></i> Configuración
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- SECCIÓN DIGITADOR - Solo visible para digitadores -->
    @if(auth('employee')->user()->rol === 'digitador')
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">⌨️ Panel de Digitador</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Gestiona datos y catálogos</p>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <a href="#" class="btn btn-warning w-100">
                                    <i class="fas fa-list me-2"></i> Productos
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="btn btn-warning w-100">
                                    <i class="fas fa-users me-2"></i> Clientes
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="btn btn-warning w-100">
                                    <i class="fas fa-tag me-2"></i> Categorías
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- SECCIÓN COMÚN - Visible para todos -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-primary">{{ $ventasHoy ?? 0 }}</h3>
                    <p class="text-muted">Ventas Hoy</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-success">Q{{ $ingresoHoy ?? '0.00' }}</h3>
                    <p class="text-muted">Ingreso Hoy</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $usuariosConectados ?? 0 }}</h3>
                    <p class="text-muted">Usuarios en Línea</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

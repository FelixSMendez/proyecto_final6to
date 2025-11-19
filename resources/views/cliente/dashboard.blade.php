@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-home me-2"></i> Bienvenido, {{ auth('cliente')->user()->getNombre() }}
            </h1>
            <p class="text-muted small">Tu portal de compras en Paints</p>
        </div>
        <div class="col-md-4 text-end">
            <form action="{{ route('cliente.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="{{ route('catalogo.index') }}" class="card text-decoration-none border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-bag fa-3x text-primary mb-3"></i>
                    <h6 class="card-title">Catálogo</h6>
                    <p class="card-text small text-muted">Ver productos disponibles</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('cliente.carrito') }}" class="card text-decoration-none border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cart-shopping fa-3x text-success mb-3"></i>
                    <h6 class="card-title">Mi Carrito</h6>
                    <p class="card-text small text-muted">Ver y editar</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('cliente.pedidos') }}" class="card text-decoration-none border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-invoice fa-3x text-info mb-3"></i>
                    <h6 class="card-title">Mis Pedidos</h6>
                    <p class="card-text small text-muted">Historial de compras</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ auth('employee')->check() ? route('dashboard') : route('catalogo.index') }}">
            <img src="{{ asset('images/logo-paints.png') }}" alt="PAINTS Logo" style="height: 40px; margin-right: 10px; vertical-align: middle; border-radius: 4px;">
                PAINTS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> 
                                @auth('employee')
                                    {{ auth('employee')->user()->usuario }}
                                @elseauth('cliente')
                                    {{ auth('cliente')->user()->usuario }}
                                @else
                                    Cuenta
                                @endauth
                        </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
        
                        <!-- ✅ MI PERFIL - SOLO SI ESTÁ AUTENTICADO -->
                        @auth('employee')
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user me-2"></i> Mi Perfil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                        @endauth
        
                        @auth('cliente')
                            <li><a class="dropdown-item" href="{{ route('cliente.dashboard') }}">
                                <i class="fas fa-user me-2"></i> Mi Perfil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                        @endauth

                        <!-- ✅ CERRAR SESIÓN - SOLO SI ESTÁ AUTENTICADO -->
                        @auth('employee')
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        @endauth

                        @auth('cliente')
                            <li>
                                <form method="POST" action="{{ route('cliente.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        @endauth

                        <!-- ✅ INICIAR SESIÓN - SOLO SI NO ESTÁ AUTENTICADO -->
                        @if(!isset($showLoginOptions) || $showLoginOptions)
                            @if(!auth('employee')->check() && !auth('cliente')->check())
                                <li><a class="dropdown-item" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login Empleado
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('cliente.login') }}">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login Cliente
                                </a></li>
                            @endif
                        @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

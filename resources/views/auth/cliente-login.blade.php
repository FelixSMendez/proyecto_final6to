@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <!-- Header -->
                <div class="text-center mb-4">
                    <i class="fas fa-paint-brush fa-3x text-primary mb-3"></i>
                    <h2 class="card-title">PAINTS</h2>
                    <p class="text-muted">Portal de Clientes</p>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('cliente.login.store') }}">
                    @csrf

                    <!-- Usuario -->
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control @error('usuario') is-invalid @enderror" 
                               id="usuario" name="usuario" value="{{ old('usuario') }}" required autofocus>
                        @error('usuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control @error('contrasena') is-invalid @enderror" 
                               id="contrasena" name="contrasena" required>
                        @error('contrasena')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Recuérdame</label>
                    </div>

                    <!-- Botón -->
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>

                <hr class="my-4">
                
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-muted small">¿Eres empleado?</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
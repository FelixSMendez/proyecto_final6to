@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Cliente</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required maxlength="100">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $cliente->email) }}" required maxlength="100">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dirección" class="form-label">Dirección *</label>
                            <input type="text" class="form-control @error('dirección') is-invalid @enderror" id="dirección" name="dirección" value="{{ old('dirección', $cliente->dirección) }}" required maxlength="150">
                            @error('dirección')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="teléfono" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control @error('teléfono') is-invalid @enderror" id="teléfono" name="teléfono" value="{{ old('teléfono', $cliente->teléfono) }}" required maxlength="20">
                            @error('teléfono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- MAPA GOOGLE -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ubicación (Haz clic en el mapa para cambiar)</label>
                            <div id="mapEditar" style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px;"></div>
                            <small class="text-muted d-block mb-2">Haz clic en el punto donde te ubicas. Se guardará automáticamente.</small>
                            
                            <input type="hidden" name="latitud" id="latitudCliente" value="{{ old('latitud', $cliente->latitud) }}">
                            <input type="hidden" name="longitud" id="longitudCliente" value="{{ old('longitud', $cliente->longitud) }}">
                            
                            <div id="coordenadas" class="alert alert-info">
                                Ubicación actual: <strong id="coordText">{{ $cliente->latitud ? $cliente->latitud . ', ' . $cliente->longitud : 'Sin definir' }}</strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="">-- Selecciona un tipo --</option>
                                <option value="mayorista" {{ old('tipo', $cliente->tipo) == 'mayorista' ? 'selected' : '' }}>Mayorista</option>
                                <option value="minorista" {{ old('tipo', $cliente->tipo) == 'minorista' ? 'selected' : '' }}>Minorista</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
let mapEditar;
let marcadorEditar;

function initMapEditar() {
    // Obtener lat/lng actuales o centro en Guatemala
    const latActual = parseFloat(document.getElementById('latitudCliente').value) || 14.6349;
    const lngActual = parseFloat(document.getElementById('longitudCliente').value) || -90.5069;
    
    const ubicacionActual = { lat: latActual, lng: lngActual };

    mapEditar = new google.maps.Map(document.getElementById('mapEditar'), {
        zoom: 12,
        center: ubicacionActual,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // Si tiene ubicación guardada, mostrar marcador
    if (document.getElementById('latitudCliente').value) {
        marcadorEditar = new google.maps.Marker({
            position: ubicacionActual,
            map: mapEditar,
            title: 'Tu ubicación actual'
        });
    }

    // Escuchar clic en el mapa
    mapEditar.addListener('click', (event) => {
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        setLocationEditar(lat, lng);
    });
}

function setLocationEditar(lat, lng) {
    // Llenar inputs hidden
    document.getElementById('latitudCliente').value = lat;
    document.getElementById('longitudCliente').value = lng;

    // Mostrar coordenadas
    document.getElementById('coordText').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;

    // Eliminar marcador anterior si existe
    if (marcadorEditar) {
        marcadorEditar.setMap(null);
    }

    // Crear nuevo marcador
    marcadorEditar = new google.maps.Marker({
        position: { lat, lng },
        map: mapEditar,
        title: 'Tu ubicación'
    });

    // Centrar mapa en el marcador
    mapEditar.setCenter({ lat, lng });
}

// Inicializar mapa cuando se cargue la página
document.addEventListener('DOMContentLoaded', initMapEditar);
</script>
@endpush
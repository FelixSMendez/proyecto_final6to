@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Crear Nuevo Cliente</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="100">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required maxlength="100">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dirección" class="form-label">Dirección *</label>
                            <input type="text" class="form-control @error('dirección') is-invalid @enderror" id="dirección" name="dirección" value="{{ old('dirección') }}" required maxlength="150">
                            @error('dirección')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="teléfono" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control @error('teléfono') is-invalid @enderror" id="teléfono" name="teléfono" value="{{ old('teléfono') }}" required maxlength="20">
                            @error('teléfono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- MAPA GOOGLE -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ubicación (Haz clic en el mapa para seleccionar)</label>
                            <div id="map" style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px;"></div>
                            <small class="text-muted d-block mb-2">Haz clic en el punto donde te ubicas. Se guardará automáticamente.</small>
                            
                            <input type="hidden" name="latitud" id="latitudCliente">
                            <input type="hidden" name="longitud" id="longitudCliente">
                            
                            <div id="coordenadas" class="alert alert-info" style="display:none;">
                                Ubicación seleccionada: <strong id="coordText"></strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="">-- Selecciona un tipo --</option>
                                <option value="mayorista" {{ old('tipo') == 'mayorista' ? 'selected' : '' }}>Mayorista</option>
                                <option value="minorista" {{ old('tipo') == 'minorista' ? 'selected' : '' }}>Minorista</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Guardar
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
let map;
let marcador;

function initMap() {
    // Centro por defecto en Guatemala
    const guatemala = { lat: 14.6349, lng: -90.5069 };

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: guatemala,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // Escuchar clic en el mapa
    map.addListener('click', (event) => {
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        setLocation(lat, lng);
    });
}

function setLocation(lat, lng) {
    // Llenar inputs hidden
    document.getElementById('latitudCliente').value = lat;
    document.getElementById('longitudCliente').value = lng;

    // Mostrar coordenadas
    document.getElementById('coordText').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    document.getElementById('coordenadas').style.display = 'block';

    // Eliminar marcador anterior si existe
    if (marcador) {
        marcador.setMap(null);
    }

    // Crear nuevo marcador
    marcador = new google.maps.Marker({
        position: { lat, lng },
        map: map,
        title: 'Tu ubicación'
    });

    // Centrar mapa en el marcador
    map.setCenter({ lat, lng });
}

// Inicializar mapa cuando se cargue la página
document.addEventListener('DOMContentLoaded', initMap);
</script>
@endpush
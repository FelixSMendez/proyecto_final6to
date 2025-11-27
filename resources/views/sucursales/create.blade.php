@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Crear Nueva Sucursal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sucursales.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="100">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dirección" class="form-label">Dirección *</label>
                            <input type="text" class="form-control @error('dirección') is-invalid @enderror" 
                                   id="dirección" name="dirección" value="{{ old('dirección') }}" required maxlength="150">
                            @error('dirección')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad *</label>
                            <input type="text" class="form-control @error('ciudad') is-invalid @enderror" 
                                   id="ciudad" name="ciudad" value="{{ old('ciudad') }}" required maxlength="100">
                            @error('ciudad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- MAPA GOOGLE -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ubicación de Sucursal (Haz clic en el mapa) *</label>
                            <div id="mapSucursal" style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px;"></div>
                            <small class="text-muted d-block mb-2">Haz clic en el mapa para seleccionar la ubicación de la sucursal.</small>
                            
                            <input type="hidden" name="latitud" id="latitudSucursal" value="{{ old('latitud') }}" required>
                            <input type="hidden" name="longitud" id="longitudSucursal" value="{{ old('longitud') }}" required>
                            
                            <div id="coordenadas" class="alert alert-info" style="display:none;">
                                Ubicación seleccionada: <strong id="coordText"></strong>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Guardar
                            </button>
                            <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">
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
let mapSucursal;
let marcadorSucursal;

function initMapSucursal() {
    const guatemala = { lat: 14.6349, lng: -90.5069 };

    mapSucursal = new google.maps.Map(document.getElementById('mapSucursal'), {
        zoom: 12,
        center: guatemala,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    mapSucursal.addListener('click', (event) => {
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        setLocationSucursal(lat, lng);
    });
}

function setLocationSucursal(lat, lng) {
    document.getElementById('latitudSucursal').value = lat;
    document.getElementById('longitudSucursal').value = lng;

    document.getElementById('coordText').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    document.getElementById('coordenadas').style.display = 'block';

    if (marcadorSucursal) {
        marcadorSucursal.setMap(null);
    }

    marcadorSucursal = new google.maps.Marker({
        position: { lat, lng },
        map: mapSucursal,
        title: 'Ubicación de sucursal'
    });

    mapSucursal.setCenter({ lat, lng });
}

document.addEventListener('DOMContentLoaded', initMapSucursal);
</script>
@endpush
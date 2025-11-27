@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Sucursal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sucursales.update', $sucursal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $sucursal->nombre) }}" required maxlength="100">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dirección" class="form-label">Dirección *</label>
                            <input type="text" class="form-control @error('dirección') is-invalid @enderror" 
                                   id="dirección" name="dirección" value="{{ old('dirección', $sucursal->dirección) }}" required maxlength="150">
                            @error('dirección')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad *</label>
                            <input type="text" class="form-control @error('ciudad') is-invalid @enderror" 
                                   id="ciudad" name="ciudad" value="{{ old('ciudad', $sucursal->ciudad) }}" required maxlength="100">
                            @error('ciudad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- MAPA GOOGLE -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ubicación de Sucursal (Haz clic para cambiar) *</label>
                            <div id="mapSucursal" style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px;"></div>
                            <small class="text-muted d-block mb-2">Haz clic en el mapa para cambiar la ubicación de la sucursal.</small>
                            
                            <input type="hidden" name="latitud" id="latitudSucursal" value="{{ old('latitud', $sucursal->latitud) }}" required>
                            <input type="hidden" name="longitud" id="longitudSucursal" value="{{ old('longitud', $sucursal->longitud) }}" required>
                            
                            <div id="coordenadas" class="alert alert-info">
                                Ubicación actual: <strong id="coordText">{{ $sucursal->latitud }}, {{ $sucursal->longitud }}</strong>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Actualizar
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
    const latActual = parseFloat(document.getElementById('latitudSucursal').value) || 14.6349;
    const lngActual = parseFloat(document.getElementById('longitudSucursal').value) || -90.5069;
    
    const ubicacionActual = { lat: latActual, lng: lngActual };

    mapSucursal = new google.maps.Map(document.getElementById('mapSucursal'), {
        zoom: 12,
        center: ubicacionActual,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    if (document.getElementById('latitudSucursal').value) {
        marcadorSucursal = new google.maps.Marker({
            position: ubicacionActual,
            map: mapSucursal,
            title: 'Ubicación actual'
        });
    }

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
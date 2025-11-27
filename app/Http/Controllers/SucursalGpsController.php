<?php
namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalGpsController extends Controller
{
    public function sucursalMasCercana(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $lat = $request->lat;
        $lng = $request->lng;

        // Traer solo sucursales con coordenadas
        $sucursales = Sucursal::whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->get();

        if ($sucursales->isEmpty()) {
            return response()->json([
                'ok' => false,
                'message' => 'No hay sucursales con coordenadas registradas.',
            ], 404);
        }

        $R = 6371; // radio de la Tierra en km
        $sucursalMasCercana = null;
        $distanciaMinima = null;

        foreach ($sucursales as $sucursal) {
            $dLat = deg2rad($sucursal->latitud - $lat);
            $dLng = deg2rad($sucursal->longitud - $lng);

            $a = sin($dLat / 2) * sin($dLat / 2) +
                 cos(deg2rad($lat)) * cos(deg2rad($sucursal->latitud)) *
                 sin($dLng / 2) * sin($dLng / 2);

            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distancia = $R * $c; // km

            if (is_null($distanciaMinima) || $distancia < $distanciaMinima) {
                $distanciaMinima = $distancia;
                $sucursalMasCercana = $sucursal;
            }
        }

        return response()->json([
            'ok' => true,
            'sucursal' => [
                'id'        => $sucursalMasCercana->id,
                'nombre'    => $sucursalMasCercana->nombre,
                'direccion' => $sucursalMasCercana->direccion ?? '',
                'latitud'   => $sucursalMasCercana->latitud,
                'longitud'  => $sucursalMasCercana->longitud,
                'distancia_km' => round($distanciaMinima, 2),
                'maps_url'  => 'https://www.google.com/maps?q=' .
                               $sucursalMasCercana->latitud . ',' .
                               $sucursalMasCercana->longitud,
            ],
        ]);
    }
}

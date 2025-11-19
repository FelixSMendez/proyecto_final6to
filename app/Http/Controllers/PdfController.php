<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cotizacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    // ✅ GENERAR PDF DE FACTURA (SIN AUTENTICACIÓN)
    public function descargarFactura($id)
    {
        $factura = Factura::with(['detalles', 'pagos', 'cliente', 'empleado'])->findOrFail($id);
        
        // Convertir logo a base64
        $logoPath = public_path('images/logo-paints.png');
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
        
        $pdf = Pdf::loadView('pdf.factura', compact('factura', 'logoBase64'));
        
        return $pdf->download('Factura_' . $factura->letra_serie . '-' . str_pad($factura->correlativo, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    // ✅ PREVISUALIZAR PDF DE FACTURA (SIN AUTENTICACIÓN)
    public function previewFactura($id)
    {
        $factura = Factura::with(['detalles', 'pagos', 'cliente', 'empleado'])->findOrFail($id);
        
        // Convertir logo a base64
        $logoPath = public_path('images/logo-paints.png');
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
        
        $pdf = Pdf::loadView('pdf.factura', compact('factura', 'logoBase64'));
        
        return $pdf->stream('Factura_' . $factura->letra_serie . '-' . str_pad($factura->correlativo, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    // ✅ GENERAR PDF DE COTIZACIÓN (SIN AUTENTICACIÓN)
    public function descargarCotizacion($id)
    {
        $cotizacion = Cotizacion::with(['detalles', 'cliente'])->findOrFail($id);
        
        // Convertir logo a base64
        $logoPath = public_path('images/logo-paints.png');
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
        
        $pdf = Pdf::loadView('pdf.cotizacion', compact('cotizacion', 'logoBase64'));
        
        return $pdf->download('Cotizacion_' . $cotizacion->numero_cotizacion . '.pdf');
    }

    // ✅ PREVISUALIZAR PDF DE COTIZACIÓN (SIN AUTENTICACIÓN)
    public function previewCotizacion($id)
    {
        $cotizacion = Cotizacion::with(['detalles', 'cliente'])->findOrFail($id);
        
        // Convertir logo a base64
        $logoPath = public_path('images/logo-paints.png');
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
        
        $pdf = Pdf::loadView('pdf.cotizacion', compact('cotizacion', 'logoBase64'));
        
        return $pdf->stream('Cotizacion_' . $cotizacion->numero_cotizacion . '.pdf');
    }
}
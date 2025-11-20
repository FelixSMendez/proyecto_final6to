<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización {{ $cotizacion->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #007bff; padding-bottom: 20px; margin-bottom: 20px; }
        .company-info { flex: 1; }
        .company-info img { width: 80px; height: auto; margin-bottom: 10px; }
        .company-info h1 { color: #007bff; font-size: 24px; margin-bottom: 5px; }
        .company-info p { font-size: 12px; color: #666; margin: 2px 0; }
        .invoice-title { text-align: right; }
        .invoice-title h2 { color: #007bff; font-size: 28px; margin-bottom: 10px; }
        .invoice-title p { font-size: 13px; color: #666; margin: 5px 0; }
        .status { display: inline-block; padding: 4px 8px; background-color: #ffc107; color: #333; border-radius: 3px; font-size: 11px; font-weight: bold; }
        
        .info-section { display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 12px; }
        .info-box { flex: 1; }
        .info-box strong { display: block; margin-top: 10px; margin-bottom: 5px; }
        .info-box p { margin: 2px 0; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table thead { background-color: #007bff; color: white; }
        table th { padding: 12px; text-align: left; font-weight: bold; font-size: 13px; }
        table td { padding: 10px 12px; border-bottom: 1px solid #ddd; font-size: 12px; }
        table tbody tr:hover { background-color: #f9f9f9; }
        
        .totals { display: flex; justify-content: flex-end; margin-bottom: 20px; }
        .totals-box { width: 350px; }
        .total-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #ddd; font-size: 13px; }
        .total-row.final { border-bottom: 3px solid #007bff; padding: 12px 0; font-weight: bold; font-size: 16px; color: #007bff; }
        
        .footer { margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd; text-align: center; font-size: 11px; color: #666; }
        .footer p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER CON LOGO -->
        <div class="header">
            <div class="company-info">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="PAINTS Logo">
                @endif
                <p><strong>Cadena de Pinturas</strong></p>
                <p>Solventes • Accesorios • Pinturas para Paredes</p>
                <p style="margin-top: 5px; font-size: 11px;">NIT: 1234567-8</p>
            </div>
            
            <div class="invoice-title">
                <h2>COTIZACIÓN</h2>
                <p style="font-size: 14px; color: #007bff;"><strong>#{{ $cotizacion->id }}</strong></p>
                <p>
                    <span class="status">{{ strtoupper($cotizacion->estado) }}</span>
                </p>
            </div>
        </div>

        <!-- INFORMACIÓN CLIENTE Y FECHAS -->
        <div class="info-section">
            <div class="info-box">
                <strong>CLIENTE:</strong>
                <p>{{ $cotizacion->cliente->usuario ?? 'N/A' }}</p>
                <p>Email: {{ $cotizacion->cliente->email ?? 'N/A' }}</p>
                <p>Teléfono: {{ $cotizacion->cliente->telefono ?? 'N/A' }}</p>
            </div>
            
            <div class="info-box" style="text-align: right;">
                <strong>FECHAS:</strong>
                <p>Emisión: <strong>{{ $cotizacion->fecha->format('d/m/Y') }}</strong></p>
                <p>Válida hasta: <strong>{{ $cotizacion->fecha_vencimiento->format('d/m/Y') }}</strong></p>
                <p style="margin-top: 10px; color: #666; font-size: 11px;">
                    Días válida: {{ $cotizacion->fecha->diffInDays($cotizacion->fecha_vencimiento) }}
                </p>
            </div>
        </div>

        <!-- TABLA DE PRODUCTOS -->
        <table>
            <thead>
                <tr>
                    <th style="width: 45%;">PRODUCTO</th>
                    <th style="width: 12%; text-align: center;">CANTIDAD</th>
                    <th style="width: 15%; text-align: right;">PRECIO UNIT.</th>
                    <th style="width: 15%; text-align: right;">DESCUENTO</th>
                    <th style="width: 13%; text-align: right;">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cotizacion->detalles as $detalle)
                    <tr>
                        <td>
                            <strong>{{ $detalle->detalleProducto->producto->nombre ?? 'Producto' }}</strong>
                        </td>
                        <td style="text-align: center;">{{ $detalle->cantidad }}</td>
                        <td style="text-align: right;">Q {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td style="text-align: right;">Q {{ number_format($detalle->subtotal - ($detalle->precio_unitario * $detalle->cantidad), 2) }}</td>
                        <td style="text-align: right;"><strong>Q {{ number_format($detalle->subtotal, 2) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">Sin productos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- TOTALES -->
        <div class="totals">
            <div class="totals-box">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>Q {{ number_format($cotizacion->total, 2) }}</span>
                </div>
                <div class="total-row final">
                    <span>TOTAL COTIZACIÓN:</span>
                    <span>Q {{ number_format($cotizacion->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p><strong>Cadena de Pinturas PAINTS</strong></p>
            <p>Cotización válida del {{ $cotizacion->fecha->format('d/m/Y') }} al {{ $cotizacion->fecha_vencimiento->format('d/m/Y') }}</p>
            <p style="margin-top: 10px;">{{ now()->format('d/m/Y H:i') }} - Documento generado automáticamente por el sistema</p>
        </div>
    </div>
</body>
</html>
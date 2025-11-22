<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $factura->letra_serie }}-{{ str_pad($factura->correlativo, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .company-info h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .company-info p {
            font-size: 12px;
            color: #666;
        }
        
        .invoice-title {
            text-align: right;
        }
        
        .invoice-title h2 {
            color: #007bff;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        .invoice-details div {
            flex: 1;
        }
        
        .invoice-details strong {
            display: block;
            margin-top: 10px;
            color: #007bff;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #007bff;
            color: white;
        }
        
        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
        }
        
        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .totals {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        
        .totals-box {
            width: 350px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }
        
        .total-row.final {
            border-bottom: 3px solid #007bff;
            padding: 12px 0;
            font-weight: bold;
            font-size: 16px;
            color: #007bff;
        }
        
        .payment-details {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .payment-details h3 {
            color: #007bff;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .payment-method {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            padding: 5px 0;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            background-color: #28a745;
            color: white;
            border-radius: 3px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <div class="company-info">
                @if($logoBase64)
                <img src="{{ $logoBase64 }}" alt="PAINTS Logo" style="width: 80px; height: auto; margin-bottom: 10px;">
                @endif
                <p><strong>Cadena de Pinturas</strong></p>
                <p>Solventes • Accesorios • Pinturas para Paredes</p>
                <p>NIT: 1234567-8</p>
            </div>
            <div class="invoice-title">
                <h2>FACTURA</h2>
                <p style="font-size: 14px; color: #007bff;"><strong>{{ $factura->letra_serie }}-{{ str_pad($factura->correlativo, 6, '0', STR_PAD_LEFT) }}</strong></p>
            </div>
        </div>

        <!-- INVOICE DETAILS -->
        <div class="invoice-details">
            <div>
                <strong>FECHA:</strong>
                {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y H:i') }}
                
                <strong style="margin-top: 15px;">CLIENTE:</strong>
                {{ $factura->cliente->usuario }}<br>
                Email: {{ $factura->cliente->email ?? 'N/A' }}
            </div>
            <div>
                @if($factura->empleado)
                    <strong>VENDEDOR:</strong>
                    {{ $factura->empleado->usuario }}
                @else
                    <strong>TIPO DE VENTA:</strong>
                    <span class="badge">EN LÍNEA</span>
                @endif
                
                <strong style="margin-top: 15px;">ESTADO:</strong>
                @if($factura->estado === 'pagada')
                    <span style="color: #28a745; font-weight: bold;"> PAGADA</span>
                @else
                    <span style="color: #ffc107; font-weight: bold;"> {{ strtoupper($factura->estado) }}</span>
                @endif
            </div>
        </div>

        <!-- PRODUCTS TABLE -->
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">PRODUCTO</th>
                    <th style="width: 10%;" class="text-center">CANTIDAD</th>
                    <th style="width: 15%;" class="text-right">PRECIO UNIT.</th>
                    <th style="width: 15%;" class="text-right">DESCUENTO</th>
                    <th style="width: 20%;" class="text-right">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php $totalProductos = 0; @endphp
                @foreach($factura->detalles as $detalle)
                    @php 
                        $subtotal = ($detalle->precio_unitario * $detalle->cantidad) - ($detalle->descuento_aplicado ?? 0);
                        $totalProductos += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $detalle->detalleProducto->producto->nombre }}</strong><br>
                            <small style="color: #666;">
                                {{ $detalle->detalleProducto->marca->nombre ?? 'N/A' }} 
                                @if($detalle->detalleProducto->color_acabado)
                                    • {{ $detalle->detalleProducto->color_acabado }}
                                @endif
                                @if($detalle->detalleProducto->tipoMedida)
                                    • {{ $detalle->detalleProducto->tipoMedida->nombre }}
                                @endif
                            </small>
                        </td>
                        <td class="text-center">{{ $detalle->cantidad }}</td>
                        <td class="text-right">Q {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td class="text-right">Q {{ number_format($detalle->descuento_aplicado ?? 0, 2) }}</td>
                        <td class="text-right"><strong>Q {{ number_format($subtotal, 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TOTALS -->
        <div class="totals">
            <div class="totals-box">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>Q {{ number_format($totalProductos, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Envío:</span>
                    <span>Q 0.00</span>
                </div>
                <div class="total-row">
                    <span>Impuestos:</span>
                    <span>Q 0.00</span>
                </div>
                <div class="total-row final">
                    <span>TOTAL A PAGAR:</span>
                    <span>Q {{ number_format($factura->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- PAYMENT DETAILS -->
        @if($factura->pagos->count() > 0)
            <div class="payment-details">
                <h3> DETALLES DE PAGO</h3>
                @foreach($factura->pagos as $pago)
                    <div class="payment-method">
                        <strong>{{ $pago->tipoPago->nombre }}</strong>
                        @if($pago->no_tarjeta)
                            <span>Tarjeta: •••••••••••{{ substr($pago->no_tarjeta, -4) }}</span>
                        @elseif($pago->no_cheque)
                            <span>Cheque: {{ $pago->no_cheque }}</span>
                        @else
                            <span>-</span>
                        @endif
                        <span>Monto: <strong>Q {{ number_format($pago->monto, 2) }}</strong></span>
                        @if($pago->cambio > 0)
                            <span style="color: #ffc107;"><strong>Cambio: Q {{ number_format($pago->cambio, 2) }}</strong></span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- FOOTER -->
        <div class="footer">
            <p><strong>Cadena de Pinturas PAINTS</strong></p>
            <p>Sucursales: Pradera Chimaltenango • Pradera Escuintla • Las Américas Mazatenango • La Trinidad Coatepeque • Pradera Xela Quetzaltenango • Miraflores Guatemala</p>
            <p style="margin-top: 10px; color: #999;">Gracias por su compra • Documento generado automáticamente</p>
            <p style="margin-top: 10px; font-size: 10px;">Factura {{ $factura->letra_serie }}-{{ str_pad($factura->correlativo, 6, '0', STR_PAD_LEFT) }} • {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
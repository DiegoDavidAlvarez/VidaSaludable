<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10mm;
            color: #333;
        }
        .header {
            position: relative;
            margin-bottom: 15px;
            border-bottom: 2px solid #1a73e8;
            height: 60px;
        }
        .logo-left, .logo-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }
        .logo-left { left: 0; }
        .logo-right { right: 0; }
        .logo-left img, .logo-right img {
            max-height: 60px;
            width: auto;
        }
        .header-title {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            color: #1a73e8;
            font-weight: bold;
        }
        h1 {
            text-align: left;
            color: #1a73e8;
            font-size: 20px;
            margin: 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #999;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        .footer {
            text-align: left;
            margin-top: 15px;
            font-size: 10px;
            color: #777;
        }
        .sale-header {
            background-color: #d9edf7;
            padding: 5px;
            margin: 10px 0;
            border-left: 4px solid #1a73e8;
            font-weight: bold;
        }
        .details-table {
            margin-bottom: 15px;
        }
        .receipt-type {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .factura { background-color: #e6f7ee; color: #2ecc71; }
        .boleta { background-color: #e6f0ff; color: #3498db; }
        .ticket { background-color: #f0e6ff; color: #9b59b6; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-left">
            <img src="{{ public_path('image/logo_VidaSaludable.png') }}" alt="Logo Vida Saludable">
        </div>
        <div class="logo-right">
            <img src="{{ public_path('image/logo_laSalle.png') }}" alt="Logo La Salle">
        </div>
        <div class="header-title">Gestión de proyectos TI</div>
    </div>

    <h1>Reporte de Ventas</h1>
    
    @foreach($sales as $sale)
    <div class="sale-header">
        Venta #{{ $sale->id }} - 
        Cliente: {{ $sale->customer->nombres }} {{ $sale->customer->apellidos }} ({{ $sale->customer->numero_documento }}) - 
        Fecha: {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }} - 
        Comprobante: 
        <span class="receipt-type {{ strtolower($sale->receipt_type) }}">
            {{ $sale->receipt_type }}
        </span> - 
        Total: S/ {{ number_format($sale->total, 2) }}
    </div>
    
    <table class="details-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleDetails as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->product->bar_code }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>S/ {{ number_format($detail->unitary_price, 2) }}</td>
                <td>S/ {{ number_format($detail->quantity * $detail->unitary_price, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Subtotal:</td>
                <td style="font-weight: bold;">S/ {{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">IGV (18%):</td>
                <td style="font-weight: bold;">S/ {{ number_format($sale->igv, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                <td style="font-weight: bold;">S/ {{ number_format($sale->total, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @endforeach

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Sistema de Gestión Vida Saludable<br>
        Total de ventas: {{ $sales->count() }} | Monto total: S/ {{ number_format($sales->sum('total'), 2) }}
    </div>
</body>
</html>
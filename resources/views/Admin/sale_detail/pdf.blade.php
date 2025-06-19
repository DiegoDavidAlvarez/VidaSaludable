<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $sale->receipt_type }} #{{ $sale->id }}</title>
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
        .logo-left {
            left: 0;
        }
        .logo-right {
            right: 0;
        }
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
        .receipt-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .receipt-info-left, .receipt-info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .receipt-info-right {
            text-align: right;
        }
        .info-block {
            margin-bottom: 15px;
        }
        .info-block strong {
            color: #1a73e8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        .totals-table {
            width: 300px;
            margin-left: auto;
            margin-bottom: 20px;
        }
        .totals-table td {
            padding: 5px 10px;
        }
        .totals-table .total-row {
            font-weight: bold;
            background-color: #1a73e8;
            color: white;
        }
        .footer {
            text-align: left;
            margin-top: 15px;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .receipt-type {
            display: inline-block;
            padding: 5px 15px;
            background-color: #1a73e8;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }
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
    
    <h1>
        <span class="receipt-type">{{ $sale->receipt_type }}</span>
        #{{ $sale->id }}
    </h1>
    
    <div class="receipt-info">
        <div class="receipt-info-left">
            <div class="info-block">
                <strong>Cliente:</strong><br>
                {{ $sale->customer->nombres }} {{ $sale->customer->apellidos }}<br>
                <strong>Documento:</strong> {{ $sale->customer->numero_documento }}
            </div>
        </div>
        <div class="receipt-info-right">
            <div class="info-block">
                <strong>Fecha de Emisión:</strong><br>
                {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}<br>
                <strong>Fecha de Impresión:</strong><br>
                {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">#</th>
                <th style="width: 15%;">Código</th>
                <th style="width: 35%;">Producto</th>
                <th style="width: 10%;">Cant.</th>
                <th style="width: 15%;">P. Unit.</th>
                <th style="width: 15%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->saleDetails as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->product->bar_code }}</td>
                    <td>
                        <strong>{{ $detail->product->name }}</strong><br>
                        <small style="color: #666;">{{ $detail->product->marca }}</small>
                    </td>
                    <td style="text-align: center;">{{ $detail->quantity }}</td>
                    <td style="text-align: right;">S/ {{ number_format($detail->unitary_price, 2) }}</td>
                    <td style="text-align: right;">S/ {{ number_format($detail->quantity * $detail->unitary_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td style="text-align: right;">S/ {{ number_format($sale->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td><strong>IGV (18%):</strong></td>
            <td style="text-align: right;">S/ {{ number_format($sale->igv, 2) }}</td>
        </tr>
        <tr class="total-row">
            <td><strong>TOTAL:</strong></td>
            <td style="text-align: right;"><strong>S/ {{ number_format($sale->total, 2) }}</strong></td>
        </tr>
    </table>

    <div class="footer">
        <strong>Vida Saludable - Sistema de Gestión</strong><br>
        Documento generado automáticamente el {{ now()->format('d/m/Y H:i') }}<br>
        {{ $sale->receipt_type }} Electrónica - Válida como comprobante de pago
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Detalles de Compra</title>
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
        .section-header {
            background-color: #d9edf7;
            padding: 5px;
            margin: 10px 0;
            border-left: 4px solid #1a73e8;
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

    <h1>Reporte de Detalles de Compra</h1>
    
    @foreach($purchaseDetails->groupBy('purchase_id') as $purchaseId => $details)
    <div class="section-header">
        Compra #{{ $purchaseId }} - 
        Proveedor: {{ $details->first()->purchase->supplier->company_name }} - 
        Fecha: {{ \Carbon\Carbon::parse($details->first()->purchase->date)->format('d/m/Y') }} - 
        Total: S/ {{ number_format($details->first()->purchase->total, 2) }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->product->bar_code }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>S/ {{ number_format($detail->unitary_cost, 2) }}</td>
                <td>S/ {{ number_format($detail->quantity * $detail->unitary_cost, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Sistema de Gestión Vida Saludable
    </div>
</body>
</html>
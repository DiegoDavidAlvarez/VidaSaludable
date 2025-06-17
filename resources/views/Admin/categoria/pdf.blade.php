<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Categorías</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
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
    <h1>Reporte de Categorías Activas</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>Activo</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Sistema de Gestión Vida Saludable
    </div>
</body>
</html>

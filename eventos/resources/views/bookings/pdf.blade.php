<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto N° {{ $booking->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1 { color: #6d3b47; margin-bottom: 0; }
        .subtitulo { color: #888; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #6d3b47; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .derecha { text-align: right; }
        .total td { font-weight: bold; font-size: 14px; border-top: 2px solid #6d3b47; }
        .nota { margin-top: 30px; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <h1>Simkus Eventos</h1>
    <p class="subtitulo">Presupuesto N° {{ $booking->id }} - Emitido el {{ now()->format('d/m/Y') }}</p>

    <h3>Datos del cliente</h3>
    <table>
        <tr><td><strong>Nombre</strong></td><td>{{ $booking->user->name }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $booking->user->email }}</td></tr>
        <tr><td><strong>Teléfono</strong></td><td>{{ $booking->user->phone ?? 'No informado' }}</td></tr>
    </table>

    <h3>Datos del evento</h3>
    <table>
        <tr><td><strong>Tipo de evento</strong></td><td>{{ $booking->category->name }}</td></tr>
        <tr><td><strong>Fecha estimada</strong></td><td>{{ $booking->estimated_date->format('d/m/Y') }}</td></tr>
        <tr><td><strong>Invitados</strong></td><td>{{ $booking->estimated_guests ?? 'Sin especificar' }}</td></tr>
        <tr><td><strong>Ideas</strong></td><td>{{ $booking->ideas_or_details ?? '-' }}</td></tr>
    </table>

    <h3>Detalle del presupuesto</h3>
    <table>
        <tr>
            <th>Concepto</th>
            <th class="derecha">Importe</th>
        </tr>
        <tr>
            <td>Decoración base - {{ $booking->category->name }}</td>
            <td class="derecha">$ {{ number_format($booking->category->base_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>{{ $booking->estimated_guests ?? 0 }} invitados × $ {{ number_format($booking->category->price_per_guest, 0, ',', '.') }}</td>
            <td class="derecha">$ {{ number_format(($booking->estimated_guests ?? 0) * $booking->category->price_per_guest, 0, ',', '.') }}</td>
        </tr>
        @foreach ($booking->services as $service)
        <tr>
            <td>Servicio extra - {{ $service->name }}</td>
            <td class="derecha">$ {{ number_format($service->price, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr class="total">
            <td>TOTAL ESTIMADO</td>
            <td class="derecha">$ {{ number_format($booking->precio_estimado, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p class="nota">
        Presupuesto estimativo, sujeto a confirmación según disponibilidad y detalles finales del evento.
        Validez: 15 días desde su emisión.
    </p>
</body>
</html>
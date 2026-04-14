<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Recibo {{ $order->folio }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 12px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 11px; color: #555; }
        .info-grid { display: table; width: 100%; margin-bottom: 18px; }
        .info-col { display: table-cell; width: 50%; vertical-align: top; }
        .info-row { margin-bottom: 4px; }
        .info-label { font-weight: bold; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.items th { background: #f0f0f0; border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        table.items td { border: 1px solid #ccc; padding: 6px 8px; }
        table.items .text-right { text-align: right; }
        .totals { width: 50%; margin-left: auto; border-collapse: collapse; }
        .totals td { padding: 4px 8px; }
        .totals .total-row { font-weight: bold; background: #f0f0f0; border-top: 2px solid #333; }
        .footer { margin-top: 30px; font-size: 10px; color: #777; text-align: center; }
        .badge-pending { background: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 4px; }
        .badge-paid    { background: #d1e7dd; color: #0a3622; padding: 2px 8px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="header">
    <h2>Recibo de Pago</h2>
    <p>Municipio de Valle de Guadalupe — Tesorería Municipal</p>
    <p>Cobros en Línea</p>
</div>

<div class="info-grid">
    <div class="info-col">
        <div class="info-row"><span class="info-label">Folio:</span> {{ $order->folio }}</div>
        <div class="info-row"><span class="info-label">Fecha:</span> {{ $order->created_at->format('d/m/Y H:i') }}</div>
        <div class="info-row"><span class="info-label">Método de pago:</span> {{ strtoupper($order->payment_method) }}</div>
        @if($order->payment_reference)
        <div class="info-row"><span class="info-label">Referencia:</span> {{ $order->payment_reference }}</div>
        @endif
    </div>
    <div class="info-col">
        <div class="info-row"><span class="info-label">Ciudadano:</span> {{ $order->user->name }}</div>
        <div class="info-row"><span class="info-label">Correo:</span> {{ $order->user->email }}</div>
        <div class="info-row">
            <span class="info-label">Estado de pago:</span>
            <span class="{{ $order->payment_status === 'Pagado' ? 'badge-paid' : 'badge-pending' }}">
                {{ $order->payment_status }}
            </span>
        </div>
    </div>
</div>

<table class="items">
    <thead>
        <tr>
            <th>Servicio</th>
            <th class="text-right" style="width:80px">Precio unit.</th>
            <th class="text-right" style="width:60px">Cant.</th>
            <th class="text-right" style="width:90px">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->service_name }}</td>
            <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
            <td class="text-right">{{ $item->quantity }}</td>
            <td class="text-right">${{ number_format($item->subtotal, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table class="totals">
    <tr>
        <td>Total:</td>
        <td class="text-right">${{ number_format($order->total, 2) }}</td>
    </tr>
    @if($order->paid_amount)
    <tr class="total-row">
        <td>Pagado:</td>
        <td class="text-right">${{ number_format($order->paid_amount, 2) }}</td>
    </tr>
    @endif
</table>

<div class="footer">
    <p>Este recibo es un comprobante de su pago en línea. Preséntelo al momento de solicitar sus copias o trámites.</p>
    <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
</div>

</body>
</html>

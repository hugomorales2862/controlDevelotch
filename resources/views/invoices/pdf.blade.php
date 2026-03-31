<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
        .title { font-size: 1.8rem; font-weight: bold; margin-bottom: 8px; }
        .label { font-size: 0.8rem; color: #666; }
        .info { font-size: 0.95rem; margin-bottom: 4px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background: #f4f4f4; font-weight: 700; text-align: left; }
        .text-right { text-align: right; }
        .totals { width: 100%; margin-top: 12px; }
        .totals td { padding: 6px; }
        .totals .label { text-align: right; }
        .totals .value { text-align: right; width: 120px; }
        .footer { margin-top: 30px; font-size: 0.8rem; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="title">Comprobante de Pago {{ $invoice->invoice_number }}</div>
            <div class="info">Emitida: {{ $invoice->issue_date->format('d/m/Y') }}</div>
            <div class="info">Vencimiento: {{ $invoice->due_date->format('d/m/Y') }}</div>
            <div class="info">Estado: {{ $invoice->status_label }}</div>
        </div>
        <div>
            <div class="label">Cliente:</div>
            <div class="info"><strong>{{ $invoice->client->name ?? '' }}</strong></div>
            <div class="info">{{ $invoice->client->company ?? '' }}</div>
            <div class="info">{{ $invoice->client->email ?? '' }}</div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item['description'] ?? '' }}</td>
                    <td>{{ $item['quantity'] ?? 0 }}</td>
                    <td class="text-right">{{ number_format($item['unit_price'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label">Sub-total:</td>
            <td class="value">Q{{ number_format($invoice->sub_total, 2) }}</td>
        </tr>
        <tr>
            <td class="label">IVA ({{ number_format($invoice->tax_rate, 2) }}%):</td>
            <td class="value">Q{{ number_format($invoice->tax, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Descuento:</td>
            <td class="value">-Q{{ number_format($invoice->discount, 2) }}</td>
        </tr>
        <tr>
            <td class="label" style="font-weight: 700;">Total a pagar:</td>
            <td class="value" style="font-weight: 700;">Q{{ number_format($invoice->total, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Nota: Pago debido en la fecha de vencimiento. Gracias por su preferencia.</p>
        <p>Generado por ControlDevelotch.</p>
    </div>
</body>
</html>

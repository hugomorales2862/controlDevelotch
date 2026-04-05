<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización {{ $quote->reference }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
            padding: 0;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #0B1120 0%, #1e293b 100%);
            color: #fff;
            padding: 30px 40px;
            position: relative;
        }
        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .header-brand {
            display: table-cell;
            vertical-align: top;
        }
        .brand-name {
            font-size: 26px;
            font-weight: 900;
            letter-spacing: -1px;
            color: #fff;
        }
        .brand-accent { color: #00f6ff; }
        .brand-subtitle {
            font-size: 9px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 3px;
        }
        .header-badge {
            display: table-cell;
            vertical-align: top;
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border: 1px solid #00f6ff;
            color: #00f6ff;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 20px;
        }
        .ref-number {
            color: #00f6ff;
            font-size: 11px;
            font-weight: 700;
            margin-top: 6px;
            font-family: monospace;
        }
        .issue-date {
            color: #64748b;
            font-size: 9px;
            margin-top: 3px;
        }

        /* Parties Grid */
        .parties {
            display: table;
            width: 100%;
            background: #f8fafc;
            border-bottom: 3px solid #00f6ff;
        }
        .party {
            display: table-cell;
            width: 50%;
            padding: 20px 30px;
            vertical-align: top;
        }
        .party-from {
            border-right: 1px solid #e2e8f0;
        }
        .party-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #00f6ff;
            margin-bottom: 8px;
        }
        .party-name {
            font-size: 14px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .party-sub {
            font-size: 10px;
            color: #64748b;
            margin-bottom: 2px;
        }

        /* Quote Details Bar */
        .details-bar {
            display: table;
            width: 100%;
            background: #0B1120;
            padding: 12px 30px;
        }
        .detail-item {
            display: table-cell;
            text-align: center;
        }
        .detail-label {
            font-size: 7px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .detail-value {
            font-size: 11px;
            font-weight: 700;
            color: #e2e8f0;
            margin-top: 2px;
        }
        .detail-value.highlight { color: #00f6ff; }

        /* Main Content */
        .content {
            padding: 30px 40px;
        }

        /* Description */
        .section-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #00f6ff;
            border-left: 3px solid #00f6ff;
            padding-left: 8px;
            margin-bottom: 8px;
        }
        .description-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px 15px;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 24px;
            font-size: 10px;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table thead tr {
            background: #0f172a;
            color: #fff;
        }
        .items-table thead th {
            padding: 10px 12px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .items-table thead th:first-child { text-align: left; }
        .items-table thead th:not(:first-child) { text-align: right; }
        .items-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
        .items-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        .items-table tbody td {
            padding: 10px 12px;
            vertical-align: top;
        }
        .items-table tbody td:not(:first-child) {
            text-align: right;
        }
        .service-name {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .service-desc {
            font-size: 9px;
            color: #64748b;
        }
        .price {
            font-weight: 700;
            color: #0f172a;
        }

        /* Totals */
        .totals-area {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        .totals-spacer {
            display: table-cell;
            width: 60%;
        }
        .totals-box {
            display: table-cell;
            width: 40%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px 20px;
        }
        .totals-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        .totals-label, .totals-value {
            display: table-cell;
            font-size: 10px;
            color: #64748b;
        }
        .totals-value { text-align: right; }
        .totals-divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 8px 0;
        }
        .total-final-label, .total-final-value {
            display: table-cell;
            font-size: 14px;
            font-weight: 900;
            color: #0f172a;
        }
        .total-final-value {
            text-align: right;
            color: #0B1120;
        }

        /* Notes */
        .notes-section {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px dashed #e2e8f0;
        }
        .notes-content {
            background: #f8fafc;
            border-radius: 6px;
            padding: 12px 15px;
            font-size: 9px;
            color: #64748b;
            line-height: 1.7;
            font-style: italic;
        }

        /* Footer */
        .footer {
            background: #0B1120;
            padding: 15px 40px;
            margin-top: 30px;
            display: table;
            width: 100%;
        }
        .footer-left, .footer-right {
            display: table-cell;
            vertical-align: middle;
        }
        .footer-left {
            font-size: 8px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer-right {
            text-align: right;
            font-size: 8px;
            color: #00f6ff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Valid Until Alert */
        .validity-box {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-left: 4px solid #f97316;
            border-radius: 6px;
            padding: 8px 14px;
            margin-bottom: 20px;
            display: table;
            width: 100%;
        }
        .validity-label, .validity-date {
            display: table-cell;
            vertical-align: middle;
        }
        .validity-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9a3412;
        }
        .validity-date {
            text-align: right;
            font-size: 11px;
            font-weight: 900;
            color: #c2410c;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-top">
            <div class="header-brand">
                <div class="brand-name">DEVELOTECH <span class="brand-accent">CORE</span></div>
                <div class="brand-subtitle">Soluciones Tecnológicas de Alto Impacto</div>
            </div>
            <div class="header-badge">
                @php
                    $statusLabels = [
                        'draft' => 'Borrador',
                        'sent' => 'Enviada',
                        'approved' => 'Aprobada',
                        'rejected' => 'Rechazada',
                        'expired' => 'Expirada',
                    ];
                @endphp
                <div class="status-badge">{{ $statusLabels[$quote->status] ?? $quote->status }}</div>
                <div class="ref-number">{{ $quote->reference }}</div>
                <div class="issue-date">Emitida: {{ $quote->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Parties -->
    @php
        $isClient = $quote->quoteable_type === 'App\Models\Client';
        $entityName = $isClient
            ? ($quote->quoteable->name ?? 'N/A')
            : ($quote->quoteable->company_name ?: $quote->quoteable->contact_name ?? 'N/A');
        $entityCompany = $isClient
            ? ($quote->quoteable->company ?? '')
            : 'Prospecto Comercial';
        $entityEmail = $quote->quoteable->email ?? '';
        $entityPhone = $quote->quoteable->phone ?? '';
    @endphp
    <div class="parties">
        <div class="party party-from">
            <div class="party-label">Emisor</div>
            <div class="party-name">Develotech Core S.A.</div>
            <div class="party-sub">system@develotechgt.com</div>
            <div class="party-sub">Guatemala, C.A.</div>
        </div>
        <div class="party">
            <div class="party-label">Preparado Para</div>
            <div class="party-name">{{ $entityName }}</div>
            @if($entityCompany && $entityCompany !== $entityName)
                <div class="party-sub">{{ $entityCompany }}</div>
            @endif
            @if($entityEmail)
                <div class="party-sub">{{ $entityEmail }}</div>
            @endif
            @if($entityPhone)
                <div class="party-sub">{{ $entityPhone }}</div>
            @endif
        </div>
    </div>

    <!-- Details Bar -->
    <div class="details-bar">
        <div class="detail-item">
            <div class="detail-label">Referencia</div>
            <div class="detail-value highlight">{{ $quote->reference }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Propuesta</div>
            <div class="detail-value">{{ Str::limit($quote->title, 30) }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Fecha Emisión</div>
            <div class="detail-value">{{ $quote->created_at->format('d M Y') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Válida Hasta</div>
            <div class="detail-value" style="color: #fca5a5;">{{ $quote->valid_until ? $quote->valid_until->format('d M Y') : 'Sin límite' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Total</div>
            <div class="detail-value highlight">Q{{ number_format($quote->total, 2) }}</div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">

        <!-- Validity Alert -->
        @if($quote->valid_until)
        <div class="validity-box">
            <div class="validity-label">⏰ Oferta válida hasta</div>
            <div class="validity-date">{{ $quote->valid_until->format('d \d\e F, Y') }}</div>
        </div>
        @endif

        <!-- Description -->
        @if($quote->description)
        <div class="section-label">Objetivo / Alcance</div>
        <div class="description-box">{{ $quote->description }}</div>
        @endif

        <!-- Items Section -->
        <div class="section-label" style="margin-bottom: 12px;">Desglose de Servicios</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="text-align:left; width:50%;">Servicio / Descripción</th>
                    <th style="text-align:center; width:10%;">Cant.</th>
                    <th style="text-align:right; width:20%;">Precio Unit.</th>
                    <th style="text-align:right; width:20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->items as $item)
                <tr>
                    <td>
                        <div class="service-name">{{ $item->service->name ?? 'Servicio Personalizado' }}</div>
                        <div class="service-desc">{{ $item->description }}</div>
                    </td>
                    <td style="text-align:center;">{{ $item->quantity }}</td>
                    <td class="price">Q{{ number_format($item->unit_price, 2) }}</td>
                    <td class="price">Q{{ number_format($item->line_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-area">
            <div class="totals-spacer"></div>
            <div class="totals-box">
                <div class="totals-row">
                    <div class="totals-label">Subtotal</div>
                    <div class="totals-value">Q{{ number_format($quote->total, 2) }}</div>
                </div>
                <div class="totals-row">
                    <div class="totals-label">Impuestos</div>
                    <div class="totals-value">Incluidos</div>
                </div>
                <hr class="totals-divider">
                <div class="totals-row">
                    <div class="total-final-label">TOTAL</div>
                    <div class="total-final-value">Q{{ number_format($quote->total, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($quote->notes)
        <div class="notes-section">
            <div class="section-label">Términos y Condiciones / Notas</div>
            <div class="notes-content">{{ $quote->notes }}</div>
        </div>
        @endif

    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-left">Develotech Core © {{ date('Y') }} — Documento Confidencial</div>
        <div class="footer-right">Propuesta Comercial · {{ $quote->reference }}</div>
    </div>

</body>
</html>

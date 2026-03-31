<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante {{ $receipt->number }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            color: #1a1a1a;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        /* ─── MODO TÉRMICO (80mm) ────────────────────────────────────── */
        @media screen {
            .receipt-container.termico {
                width: 300px;
                margin: 20px auto;
                padding: 10px;
                border: 1px dashed #ccc;
            }
        }
        
        .termico {
            width: 80mm;
            padding: 5mm;
            font-size: 12px;
            line-height: 1.2;
        }
        .termico .header { text-align: center; margin-bottom: 5mm; }
        .termico .logo { font-size: 18px; font-weight: 900; letter-spacing: -1px; }
        .termico .divider { border-top: 1px dashed #000; margin: 3mm 0; }
        .termico .total { font-size: 16px; font-weight: 900; text-align: right; }

        /* ─── MODO CARTA (PDF) ────────────────────────────────────────── */
        .carta {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }
        .carta .header-grid { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .carta .brand { color: #000; }
        .carta .receipt-badge { 
            background: #f1f5f9; 
            padding: 15px 25px; 
            border-radius: 12px; 
            text-align: right; 
        }
        .carta .client-info { margin-bottom: 40px; }
        .carta .table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .carta .table th { text-align: left; background: #f8fafc; padding: 12px; font-size: 11px; text-transform: uppercase; color: #64748b; }
        .carta .table td { padding: 15px 12px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .carta .footer-sig { margin-top: 80px; display: flex; justify-content: space-around; }
        .carta .sig-box { width: 200px; border-top: 1px solid #000; text-align: center; padding-top: 10px; font-size: 10px; }

        /* Utilitarios */
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .mt-2 { margin-top: 10px; }
        .glow { text-shadow: 0 0 5px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="{{ $modo == 'termico' ? 'termico' : 'carta' }}">

    @if($modo == 'termico')
        <!-- CONTENIDO TÉRMICO -->
        <div class="header">
            <div class="logo">DEVELOTECH CORE</div>
            <div>Soluciones Tecnológicas</div>
            <div>NIT: 1234567-8</div>
        </div>

        <div class="divider"></div>

        <div>FECHA: {{ $payment->paid_at->format('d/m/Y H:i') }}</div>
        <div>RECIBO: <span class="font-bold">{{ $receipt->number }}</span></div>
        <div>OPERADOR: {{ $receipt->user->name }}</div>

        <div class="divider"></div>

        <div>CLIENTE: {{ $payment->invoice->client->name ?? 'Consumidor Final' }}</div>
        
        <div class="divider"></div>

        <div style="margin-bottom: 5px;">CONCEPTO:</div>
        <div style="font-size: 10px; font-style: italic;">{{ $receipt->concept ?? 'Pago Factura #' . $payment->invoice->number }}</div>

        <div class="divider"></div>

        <div class="total">
            TOTAL: ${{ number_format($payment->amount, 2) }}
        </div>

        <div class="divider"></div>

        <div class="text-center" style="font-size: 10px;">
            ¡Gracias por su preferencia!<br>
            www.develotech.app
        </div>

    @else
        <!-- CONTENIDO CARTA / PDF -->
        <div class="header-grid">
            <div class="brand">
                <h1 style="margin: 0; font-size: 28px; font-weight: 900;">DEVELOTECH</h1>
                <p style="margin: 0; color: #64748b; font-size: 12px; letter-spacing: 2px;">ERP CORE SYSTEM</p>
            </div>
            <div class="receipt-badge">
                <div style="font-size: 10px; color: #64748b; font-weight: bold; text-transform: uppercase;">Comprobante de Ingreso</div>
                <div style="font-size: 24px; font-weight: 900; color: #0f172a;">{{ $receipt->number }}</div>
                <div style="font-size: 12px; color: #94a3b8;">{{ $payment->paid_at->format('d M, Y') }}</div>
            </div>
        </div>

        <div class="client-info">
            <p style="font-size: 10px; font-weight: bold; color: #64748b; text-transform: uppercase; margin-bottom: 5px;">Recibimos de:</p>
            <h2 style="margin: 0; font-size: 20px;">{{ $payment->invoice->client->name ?? 'N/A' }}</h2>
            <p style="margin: 0; font-size: 14px; color: #64748b;">{{ $payment->invoice->client->company ?? '' }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Descripción del Concepto</th>
                    <th style="width: 150px; text-align: right;">Monto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="font-bold">{{ $receipt->concept ?? 'Abono a Factura #' . $payment->invoice->number }}</span>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Metodo de Pago: {{ ucfirst($payment->payment_method) }} | Referencia: {{ $payment->reference ?? 'N/A' }}</div>
                    </td>
                    <td style="text-align: right; font-weight: bold; font-size: 18px;">
                        ${{ number_format($payment->amount, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="background: #f8fafc; padding: 20px; border-radius: 12px;">
            <p style="margin: 0; font-size: 12px; color: #475569;">
                <span class="font-bold">TOTAL EN LETRAS:</span> {{ Number::spell($payment->amount) }} DÓLARES AMERICANOS.
            </p>
        </div>

        <div class="footer-sig">
            <div class="sig-box">
                Firma y Sello Digital<br>
                {{ $receipt->user->name }}
            </div>
            <div class="sig-box">
                Recibí Conforme<br>
                Cliente
            </div>
        </div>

        <div style="position: absolute; bottom: 20mm; left: 20mm; right: 20mm; border-top: 1px solid #f1f5f9; padding-top: 20px; text-align: center; font-size: 10px; color: #94a3b8;">
            Este documento es un comprobante de ingreso generado automáticamente por DEVELOTECH CORE. 
            Cualquier alteración anula su validez.
        </div>
    @endif

</body>
</html>

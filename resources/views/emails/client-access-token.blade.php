<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { margin: 0; padding: 0; background-color: #050505; font-family: 'Helvetica Neue', Arial, sans-serif; color: #ffffff; }
        .container { max-width: 480px; margin: 0 auto; padding: 40px 20px; }
        .header { text-align: center; padding-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .header h1 { font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 4px; margin: 0; color: #00f2fe; }
        .content { padding: 40px 0; text-align: center; }
        .greeting { font-size: 14px; color: #94a3b8; margin-bottom: 20px; }
        .token-box { background: linear-gradient(135deg, rgba(0,242,254,0.1) 0%, rgba(79,172,254,0.1) 100%); border: 2px solid rgba(0,242,254,0.3); border-radius: 16px; padding: 30px; margin: 30px 0; }
        .token-code { font-size: 42px; font-weight: 900; letter-spacing: 12px; color: #00f2fe; font-family: 'Courier New', monospace; }
        .token-label { font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 3px; color: #64748b; margin-top: 12px; }
        .warning { font-size: 11px; color: #64748b; font-style: italic; margin-top: 30px; line-height: 1.6; }
        .footer { text-align: center; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); font-size: 10px; color: #334155; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Develotech Global</h1>
        </div>
        <div class="content">
            <p class="greeting">Hola, <strong style="color: #ffffff;">{{ $clientName }}</strong></p>
            <p style="font-size: 13px; color: #94a3b8; line-height: 1.6;">
                Has solicitado acceder al Portal de Soporte. Usa el siguiente código para ingresar:
            </p>
            <div class="token-box">
                <div class="token-code">{{ $token }}</div>
                <div class="token-label">Código de Acceso</div>
            </div>
            <p class="warning">
                Este código es válido por 15 minutos.<br>
                Si no solicitaste este acceso, puedes ignorar este correo.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Develotech Global — Sistema de Control
        </div>
    </div>
</body>
</html>

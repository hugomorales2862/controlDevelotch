<x-mail::message>
# Recordatorio de Suscripción

Hola **{{ $clientName }}**,

Te informamos que tu suscripción al servicio **{{ $serviceName }}** está programada para su próximo cobro.

**Detalles de la Suscripción:**
- **Servicio:** {{ $serviceName }}
- **Fecha de Próximo Pago:** {{ $nextPaymentDate }}
- **Monto:** ${{ $amount }}

Asegúrate de tener fondos suficientes en tu cuenta vinculada para evitar interrupciones en el servicio.

<x-mail::button :url="config('app.url') . '/dashboard'">
Ir al Dashboard
</x-mail::button>

Gracias por elegirnos,<br>
El equipo de **{{ config('app.name', 'DEVELOTECH GLOBAL') }}**
</x-mail::message>

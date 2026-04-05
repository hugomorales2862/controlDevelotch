<x-mail::message>
# {{ $subjectLine ?? 'Notificación' }}

{!! nl2br(e($content)) !!}

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>

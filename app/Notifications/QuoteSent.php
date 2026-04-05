<?php

namespace App\Notifications;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteSent extends Notification
{
    use Queueable;

    protected Quote $quote;
    protected ?string $pdfContent;
    protected string $filename;

    public function __construct(Quote $quote, ?string $pdfContent = null, string $filename = 'cotizacion.pdf')
    {
        $this->quote = $quote;
        $this->pdfContent = $pdfContent;
        $this->filename = $filename;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $entityName = $notifiable->name ?? $notifiable->company_name ?? $notifiable->contact_name ?? 'Estimado Cliente';

        $mail = (new MailMessage)
            ->subject("Cotización {$this->quote->reference} — Develotech Core")
            ->greeting("¡Hola, {$entityName}!")
            ->line('Adjuntamos la propuesta comercial preparada especialmente para usted.')
            ->line("**Referencia:** {$this->quote->reference}")
            ->line("**Propuesta:** {$this->quote->title}")
            ->line("**Total:** Q" . number_format((float) $this->quote->total, 2))
            ->line("**Válida hasta:** " . ($this->quote->valid_until instanceof \Carbon\Carbon ? $this->quote->valid_until->format('d/m/Y') : ($this->quote->valid_until ? \Carbon\Carbon::parse($this->quote->valid_until)->format('d/m/Y') : 'Sin límite')))
            ->line('Quedo atento a cualquier consulta.')
            ->salutation('— Equipo Develotech Core');

        // Adjuntar PDF si está disponible
        if ($this->pdfContent) {
            $mail->attachData($this->pdfContent, $this->filename, [
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }

    public function toArray($notifiable): array
    {
        return [
            'quote_id'  => $this->quote->id,
            'reference' => $this->quote->reference,
            'total'     => $this->quote->total,
            'message'   => 'Cotización enviada: ' . $this->quote->reference,
        ];
    }
}

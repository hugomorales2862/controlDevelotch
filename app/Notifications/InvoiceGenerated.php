<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Invoice;

class InvoiceGenerated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = url('/invoices/' . $this->invoice->id);

        return (new MailMessage)
            ->subject('Nueva Factura Generada - DEVELOTECH GLOBAL')
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('Se ha generado una nueva factura para tu cuenta.')
            ->line('Número de Factura: ' . $this->invoice->number)
            ->line('Total: $' . number_format($this->invoice->total, 2))
            ->action('Ver Detalles de Factura', $url)
            ->line('Gracias por confiar en DEVELOTECH GLOBAL.');
    }

    public function toArray($notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'number' => $this->invoice->number,
            'amount' => $this->invoice->total,
            'message' => 'Nueva factura generada: ' . $this->invoice->number,
        ];
    }
}

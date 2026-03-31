<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Subscription;

class SubscriptionExpiring extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Suscripción con DEVELOTECH GLOBAL está por Expirar',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.expiring',
            with: [
                'clientName' => $this->subscription->client->name,
                'serviceName' => $this->subscription->service->name,
                'nextPaymentDate' => $this->subscription->next_payment_date?->format('d/m/Y'),
                'amount' => number_format($this->subscription->amount, 2),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientAccessTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $token;
    public string $clientName;

    public function __construct(string $token, string $clientName)
    {
        $this->token = $token;
        $this->clientName = $clientName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Código de Acceso | Develotech Global',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.client-access-token',
        );
    }
}

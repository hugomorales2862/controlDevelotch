<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailable;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailService
{
    /**
     * Envia un correo capturando cualquier excepcion que pudiese
     * romper el flujo de la aplicacion (ej. problemas de red, limites SMTP).
     *
     * @param string|array|object $to
     * @param Mailable $mailable
     * @return bool
     */
    public function sendSafe($to, Mailable $mailable): bool
    {
        try {
            Mail::to($to)->send($mailable);
            return true;
        } catch (TransportExceptionInterface $e) {
            Log::error('Fallo al enviar correo via SMTP: ' . $e->getMessage(), [
                'to' => $to,
                'mailable' => get_class($mailable)
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('Fallo critico al procesar el Mailable: ' . $e->getMessage(), [
                'to' => $to,
                'mailable' => get_class($mailable)
            ]);
            return false;
        }
    }
}

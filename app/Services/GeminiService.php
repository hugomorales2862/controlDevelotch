<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Client;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash-lite:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    public function getResponse(Client $client, string $userInput, string $ticketContext = '')
    {
        if (!$this->apiKey) {
            return 'Servicio de IA no configurado.';
        }

        $context = $this->buildContext($client);
        
        $systemPrompt = "Eres 'DeveloAI', el asistente inteligente de soporte de Develotech. 
        Tu objetivo es ayudar al cliente con sus dudas administrativas y técnicas básicas de forma amable y profesional.
        
        REGLAS ESTRICTAS:
        1. Solo tienes acceso a la información proporcionada en el contexto del cliente.
        2. NO menciones datos de otros clientes.
        3. NO proporciones contraseñas ni accesos a servidores. Si el cliente solicita esto, infórmale cortésmente que por políticas de seguridad no puedes revelar accesos técnicos y que un asesor revisará su caso.
        4. Si el cliente pregunta algo que no está en el contexto o que viola alguna política, indícale claramente que no puedes responder por ese motivo o por falta de información, y que el soporte humano se encargará pronto.
        5. Mantén un tono profesional, servicial y al estilo Telegram (mensajes modernos y concisos).
        6. Responde siempre en español.
        
        CONTEXTO DEL CLIENTE:
        {$context}
        
        CONTEXTO DEL TICKET ACTUAL:
        {$ticketContext}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => "Instrucciones del sistema:\n{$systemPrompt}\n\nMensaje del cliente: {$userInput}"]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1000,
                ]
            ]);

            if ($response->status() === 429) {
                Log::warning('Gemini Quota Exceeded');
                return 'He alcanzado mi límite de mensajes gratuitos por ahora. Por favor, espera un momento o contacta a un humano.';
            }

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Lo siento, tuve un problema procesando tu mensaje.';
            }

            Log::error('Gemini API Error', ['response' => $response->body()]);
            return 'Lo siento, mi servicio de IA no está disponible en este momento.';

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception', ['message' => $e->getMessage()]);
            return 'Ocurrió un error inesperado al conectar con DeveloAI.';
        }
    }

    protected function buildContext(Client $client): string
    {
        // Cargamos relaciones necesarias para el contexto
        $client->load(['subscriptions.service', 'invoices.payments']);
        
        $totalInvoiced = $client->invoices->sum('total');
        // Calculamos pagos totales sumando los pagos de cada factura
        $totalPaid = $client->invoices->flatMap->payments->sum('amount');
        $balance = $totalInvoiced - $totalPaid;
        
        $context = "Nombre: {$client->name}\n Empresa: {$client->company}\n";
        $context .= "Balance Actual: " . number_format($balance, 2) . " (Saldo pendiente de pago)\n";
        $context .= "Servicios/Suscripciones:\n";
        
        foreach($client->subscriptions as $sub) {
            $context .= "- {$sub->service->name}: Estado {$sub->status}, Pago de " . number_format($sub->amount, 2) . " ({$sub->billing_cycle}), Próximo pago: " . ($sub->next_payment_date ?? 'N/A') . "\n";
        }
        
        return $context;
    }
}

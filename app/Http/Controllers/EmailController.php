<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Mail\GenericNotification;
use App\Services\MailService;

class EmailController extends Controller
{
    protected MailService $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function create()
    {
        $clients = Client::all();
        return view('emails.create', compact('clients'));
    }

    public function store(SendEmailRequest $request)
    {
        $validated = $request->validated();

        $client = Client::findOrFail($validated['client_id']);

        // Prevent crashes on missing emails, although validation usually handles it
        if (!$client->email) {
            return back()->with('error', 'El cliente no tiene un correo registrado.');
        }

        $mailable = new GenericNotification($validated['subject'], $validated['message']);

        // Send safely without dropping to Error 500 automatically
        $success = $this->mailService->sendSafe($client->email, $mailable);

        if ($success) {
            return redirect()->route('emails.create')
                ->with('success', 'El correo ha sido enviado exitosamente al cliente o se ha encolado para envío.');
        }

        return back()->withInput()->with('error', 'Hubo un error de conexión con el proveedor SMTP. El correo no pudo ser enviado.');
    }
}

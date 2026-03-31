<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Client;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Client $client)
    {
        $contacts = $client->contacts()->latest()->paginate(20);
        return view('contacts.index', compact('contacts', 'client'));
    }

    public function create(Client $client)
    {
        return view('contacts.create', compact('client'));
    }

    public function store(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:150',
            'email'     => 'nullable|email|max:150',
            'phone'     => 'nullable|string|max:30',
            'role'      => 'nullable|string|max:100',
            'metadata'  => 'nullable|array',
        ]);

        $data['client_id'] = $client->cli_id;

        Contact::create($data);
        return redirect()->route('clients.contacts.index', $client)->with('success', 'Contacto creado correctamente.');
    }

    public function show(Client $client, Contact $contact)
    {
        return view('contacts.show', compact('contact', 'client'));
    }

    public function edit(Client $client, Contact $contact)
    {
        return view('contacts.edit', compact('contact', 'client'));
    }

    public function update(Request $request, Client $client, Contact $contact)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:150',
            'email'     => 'nullable|email|max:150',
            'phone'     => 'nullable|string|max:30',
            'role'      => 'nullable|string|max:100',
            'metadata'  => 'nullable|array',
        ]);

        $contact->update($data);
        return redirect()->route('clients.contacts.index', $client)->with('success', 'Contacto actualizado correctamente.');
    }

    public function destroy(Client $client, Contact $contact)
    {
        $contact->delete();
        return redirect()->route('clients.contacts.index', $client)->with('success', 'Contacto eliminado correctamente.');
    }
}

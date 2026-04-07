<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['client', 'service'])->latest()->paginate(10);
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $clients = Client::all();
        $services = Service::all();
        return view('subscriptions.create', compact('clients', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'service_id' => 'required|exists:services,id',
            'status' => 'required|in:active,suspended,canceled',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Subscription::create($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Suscripción creada con éxito.');
    }

    public function show(Subscription $subscription)
    {
        return view('subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        $clients = Client::all();
        $services = Service::all();
        return view('subscriptions.edit', compact('subscription', 'clients', 'services'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'service_id' => 'required|exists:services,id',
            'status' => 'required|in:active,suspended,canceled',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $subscription->update($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Suscripción actualizada con éxito.');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Suscripción eliminada con éxito.');
    }
}

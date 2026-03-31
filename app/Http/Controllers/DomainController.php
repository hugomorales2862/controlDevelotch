<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Client;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view domains')->only(['index', 'show']);
        $this->middleware('permission:create domains')->only(['create', 'store']);
        $this->middleware('permission:edit domains')->only(['edit', 'update']);
        $this->middleware('permission:delete domains')->only(['destroy']);
    }

    public function index()
    {
        $domains = Domain::with('client')->orderBy('expires_at', 'asc')->paginate(15);
        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        $clients = Client::orderBy('company')->get();
        return view('domains.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'name' => 'required|string|max:255|unique:domains,name',
            'expires_at' => 'required|date',
            'status' => 'required|in:active,expired,pending_transfer,suspended',
        ]);

        Domain::create($validated);

        return redirect()->route('domains.index')
            ->with('success', 'Dominio registrado con éxito.');
    }

    public function show(Domain $domain)
    {
        return view('domains.show', compact('domain'));
    }

    public function edit(Domain $domain)
    {
        $clients = Client::orderBy('company')->get();
        return view('domains.edit', compact('domain', 'clients'));
    }

    public function update(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'name' => 'required|string|max:255|unique:domains,name,' . $domain->id,
            'expires_at' => 'required|date',
            'status' => 'required|in:active,expired,pending_transfer,suspended',
        ]);

        $domain->update($validated);

        return redirect()->route('domains.index')
            ->with('success', 'Dominio actualizado con éxito.');
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();
        return redirect()->route('domains.index')
            ->with('success', 'Dominio eliminado.');
    }
}

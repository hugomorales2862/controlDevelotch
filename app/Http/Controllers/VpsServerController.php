<?php

namespace App\Http\Controllers;

use App\Models\VpsServer;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VpsServerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view servers')->only(['index', 'show']);
        $this->middleware('permission:create servers')->only(['create', 'store']);
        $this->middleware('permission:edit servers')->only(['edit', 'update']);
        $this->middleware('permission:delete servers')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servers = VpsServer::with('client')->orderBy('created_at', 'desc')->paginate(15);
        return view('servers.index', compact('servers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('company')->get();
        return view('servers.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'hostname' => 'required|string|max:255|unique:vps_servers,hostname',
            'ip_address' => 'required|ip',
            'os' => 'required|string|max:100',
            'cpu_cores' => 'required|integer|min:1',
            'ram_gb' => 'required|integer|min:1',
            'storage_gb' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,suspended,terminated',
            'monthly_cost' => 'required|numeric|min:0',
            'setup_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:setup_date',
            'details' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();

        VpsServer::create($validated);

        return redirect()->route('servers.index')
            ->with('success', 'VPS Server created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VpsServer $server)
    {
        $server->load(['client', 'credentials']);
        return view('servers.show', compact('server'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VpsServer $server)
    {
        $clients = Client::orderBy('company')->get();
        return view('servers.edit', compact('server', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VpsServer $server)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'hostname' => 'required|string|max:255|unique:vps_servers,hostname,' . $server->id,
            'ip_address' => 'required|ip',
            'os' => 'required|string|max:100',
            'cpu_cores' => 'required|integer|min:1',
            'ram_gb' => 'required|integer|min:1',
            'storage_gb' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,suspended,terminated',
            'monthly_cost' => 'required|numeric|min:0',
            'setup_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:setup_date',
            'details' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $server->update($validated);

        return redirect()->route('servers.index')
            ->with('success', 'VPS Server updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VpsServer $server)
    {
        $server->delete();

        return redirect()->route('servers.index')
            ->with('success', 'VPS Server deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ServerCredential;
use App\Models\VpsServer;
use Illuminate\Http\Request;

class ServerCredentialController extends Controller
{
    public function index()
    {
        $credentials = ServerCredential::with('vpsServer')->latest()->paginate(20);
        return view('credentials.index', compact('credentials'));
    }

    public function create()
    {
        $servers = VpsServer::orderBy('name')->get();
        return view('credentials.create', compact('servers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vps_server_id' => 'required|exists:vps_servers,id',
            'username'      => 'required|string|max:100',
            'password'      => 'required|string|max:500',
            'ssh_key'       => 'nullable|string',
        ]);

        ServerCredential::create($data);
        return redirect()->route('credentials.index')->with('success', 'Credencial guardada correctamente.');
    }

    public function show(ServerCredential $credential)
    {
        $credential->load('vpsServer');
        return view('credentials.show', compact('credential'));
    }

    public function edit(ServerCredential $credential)
    {
        $servers = VpsServer::orderBy('name')->get();
        return view('credentials.edit', compact('credential', 'servers'));
    }

    public function update(Request $request, ServerCredential $credential)
    {
        $data = $request->validate([
            'vps_server_id' => 'required|exists:vps_servers,id',
            'username'      => 'required|string|max:100',
            'password'      => 'nullable|string|max:500',
            'ssh_key'       => 'nullable|string',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $credential->update($data);
        return redirect()->route('credentials.index')->with('success', 'Credencial actualizada.');
    }

    public function destroy(ServerCredential $credential)
    {
        $credential->delete();
        return redirect()->route('credentials.index')->with('success', 'Credencial eliminada.');
    }
}

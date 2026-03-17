<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::latest()->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'fecha_registro' => 'required|date',
            'estado' => 'required|in:activo,suspendido',
            'contacto_tecnico' => 'nullable|string',
            'contacto_administrativo' => 'nullable|string',
            'notas' => 'nullable|string',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'fecha_registro' => 'required|date',
            'estado' => 'required|in:activo,suspendido',
            'contacto_tecnico' => 'nullable|string',
            'contacto_administrativo' => 'nullable|string',
            'notas' => 'nullable|string',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with('cliente')->latest()->paginate(10);
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        $clientes = Cliente::where('estado', 'activo')->get();
        return view('servicios.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'precio_mensual' => 'required|numeric|min:0',
            'dia_pago' => 'required|integer|min:1|max:31',
            'estado' => 'required|in:activo,suspendido,cancelado',
            'proveedor' => 'nullable|string',
            'ip_servidor' => 'nullable|string',
            'so' => 'nullable|string',
            'panel_control' => 'nullable|string',
            'dominio' => 'nullable|string',
            'proveedor_dominio' => 'nullable|string',
            'fecha_vencimiento_dominio' => 'nullable|date',
            'proveedor_dns' => 'nullable|string',
            'registros_dns' => 'nullable|string',
            'tipo_db' => 'nullable|string',
        ]);

        Servicio::create($validated);

        return redirect()->route('servicios.index')->with('success', 'Servicio creado correctamente.');
    }

    public function show(Servicio $servicio)
    {
        return view('servicios.show', compact('servicio'));
    }

    public function edit(Servicio $servicio)
    {
        $clientes = Cliente::where('estado', 'activo')->get();
        return view('servicios.edit', compact('servicio', 'clientes'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'precio_mensual' => 'required|numeric|min:0',
            'dia_pago' => 'required|integer|min:1|max:31',
            'estado' => 'required|in:activo,suspendido,cancelado',
            'proveedor' => 'nullable|string',
            'ip_servidor' => 'nullable|string',
            'so' => 'nullable|string',
            'panel_control' => 'nullable|string',
            'dominio' => 'nullable|string',
            'proveedor_dominio' => 'nullable|string',
            'fecha_vencimiento_dominio' => 'nullable|date',
            'proveedor_dns' => 'nullable|string',
            'registros_dns' => 'nullable|string',
            'tipo_db' => 'nullable|string',
        ]);

        $servicio->update($validated);

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }
}

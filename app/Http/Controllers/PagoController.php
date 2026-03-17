<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cliente;
use App\Models\Servicio;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['cliente', 'servicio'])->latest()->paginate(10);
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $servicios = Servicio::all();
        return view('pagos.create', compact('clientes', 'servicios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'monto' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'required|date',
            'estado' => 'required|in:pendiente,pagado,vencido',
            'metodo_pago' => 'nullable|string',
            'fecha_pago' => 'nullable|date',
            'comprobante' => 'nullable|image|max:2048',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes', 'public');
            $validated['comprobante'] = $path;
        }

        Pago::create($validated);

        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    public function show(Pago $pago)
    {
        return view('pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $clientes = Cliente::all();
        $servicios = Servicio::all();
        return view('pagos.edit', compact('pago', 'clientes', 'servicios'));
    }

    public function update(Request $request, Pago $pago)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'monto' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'required|date',
            'estado' => 'required|in:pendiente,pagado,vencido',
            'metodo_pago' => 'nullable|string',
            'fecha_pago' => 'nullable|date',
            'comprobante' => 'nullable|image|max:2048',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes', 'public');
            $validated['comprobante'] = $path;
        }

        $pago->update($validated);

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\Categoria;
use Illuminate\Http\Request;

class TransaccionController extends Controller
{
    public function index()
    {
        $transacciones = Transaccion::with('categoria')->latest()->paginate(10);
        return view('transacciones.index', compact('transacciones'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('transacciones.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'categoria_id' => 'nullable|exists:categorias,id',
            'descripcion' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'metodo_pago' => 'nullable|string',
            'comprobante' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes_finanzas', 'public');
            $validated['comprobante'] = $path;
        }

        Transaccion::create($validated);

        return redirect()->route('transacciones.index')->with('success', 'Transacción registrada correctamente.');
    }

    public function show(Transaccion $transaccione)
    {
        return view('transacciones.show', compact('transaccione'));
    }

    public function edit(Transaccion $transaccione)
    {
        $categorias = Categoria::all();
        return view('transacciones.edit', compact('transaccione', 'categorias'));
    }

    public function update(Request $request, Transaccion $transaccione)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'categoria_id' => 'nullable|exists:categorias,id',
            'descripcion' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'metodo_pago' => 'nullable|string',
            'comprobante' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes_finanzas', 'public');
            $validated['comprobante'] = $path;
        }

        $transaccione->update($validated);

        return redirect()->route('transacciones.index')->with('success', 'Transacción actualizada correctamente.');
    }

    public function destroy(Transaccion $transaccione)
    {
        $transaccione->delete();
        return redirect()->route('transacciones.index')->with('success', 'Transacción eliminada correctamente.');
    }
}

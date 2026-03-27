<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['client', 'service'])->latest('sale_date')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $clients = Client::all();
        $services = Service::all();
        return view('sales.create', compact('clients', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'nullable|exists:services,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:255',
            'sale_date' => 'required|date',
        ]);

        Sale::create($validated);

        return redirect()->route('sales.index')->with('success', 'Venta registrada con éxito.');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $clients = Client::all();
        $services = Service::all();
        return view('sales.edit', compact('sale', 'clients', 'services'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'nullable|exists:services,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:255',
            'sale_date' => 'required|date',
        ]);

        $sale->update($validated);

        return redirect()->route('sales.index')->with('success', 'Venta actualizada con éxito.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venta eliminada con éxito.');
    }
}

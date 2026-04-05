<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProspectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver prospectos')->only(['index', 'show']);
        $this->middleware('permission:crear prospectos')->only(['create', 'store']);
        $this->middleware('permission:editar prospectos')->only(['edit', 'update']);
        $this->middleware('permission:eliminar prospectos')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prospects = Prospect::orderBy('created_at', 'desc')->paginate(15);
        return view('prospects.index', compact('prospects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prospects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:prospects,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url',
            'industry' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|in:new,contacted,qualified,proposal,lost,won',
        ]);

        $validated['created_by'] = Auth::id();

        $prospect = Prospect::create($validated);
        $prospect->load('creator'); 

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'prospect' => $prospect,
                'identifier' => "App\Models\Prospect|{$prospect->id}"
            ], 201);
        }

        return redirect()->route('prospects.index')
            ->with('success', 'Prospect created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prospect $prospect)
    {
        return view('prospects.show', compact('prospect'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prospect $prospect)
    {
        return view('prospects.edit', compact('prospect'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prospect $prospect)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:prospects,email,' . $prospect->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url',
            'industry' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|in:new,contacted,qualified,proposal,lost,won',
        ]);

        $prospect->update($validated);

        return redirect()->route('prospects.index')
            ->with('success', 'Prospect updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prospect $prospect)
    {
        $prospect->delete();

        return redirect()->route('prospects.index')
            ->with('success', 'Prospect deleted successfully.');
    }

    public function convertToClient(Prospect $prospect)
    {
        // Usa la lógica del modelo para migrar datos y cotizaciones
        $client = $prospect->toClient();

        return redirect()->route('clients.show', $client)
            ->with('success', '¡Prospecto convertido a Cliente con éxito! Se han transferido sus cotizaciones si existían.');
    }
}

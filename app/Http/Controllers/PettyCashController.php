<?php

namespace App\Http\Controllers;

use App\Models\PettyCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PettyCashController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view petty cash')->only(['index', 'show']);
        $this->middleware('permission:create petty cash')->only(['create', 'store']);
        $this->middleware('permission:edit petty cash')->only(['edit', 'update']);
        $this->middleware('permission:delete petty cash')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pettyCashes = PettyCash::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('petty-cash.index', compact('pettyCashes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petty-cash.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'receipt_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        PettyCash::create($validated);

        return redirect()->route('petty-cash.index')
            ->with('success', 'Petty cash transaction recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PettyCash $pettyCash)
    {
        return view('petty-cash.show', compact('pettyCash'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PettyCash $pettyCash)
    {
        return view('petty-cash.edit', compact('pettyCash'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PettyCash $pettyCash)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'receipt_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $pettyCash->update($validated);

        return redirect()->route('petty-cash.index')
            ->with('success', 'Petty cash transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PettyCash $pettyCash)
    {
        $pettyCash->delete();

        return redirect()->route('petty-cash.index')
            ->with('success', 'Petty cash transaction deleted successfully.');
    }
}

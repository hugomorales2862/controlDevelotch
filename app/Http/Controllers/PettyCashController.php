<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePettyCashRequest;
use App\Http\Requests\UpdatePettyCashRequest;
use App\Models\PettyCash;
use App\Services\PettyCashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PettyCashController extends Controller
{
    protected PettyCashService $pettyCashService;

    public function __construct(PettyCashService $pettyCashService)
    {
        $this->pettyCashService = $pettyCashService;
        $this->middleware('permission:ver caja chica')->only(['index', 'show']);
        $this->middleware('permission:crear caja chica')->only(['create', 'store']);
        $this->middleware('permission:editar caja chica')->only(['edit', 'update']);
        $this->middleware('permission:eliminar caja chica')->only(['destroy']);
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
    public function store(StorePettyCashRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();
        $validated['purpose'] = $validated['description']; // Compatibility

        try {
            $this->pettyCashService->recordTransaction($validated);
            return redirect()->route('petty-cash.index')
                ->with('success', 'Petty cash transaction recorded successfully.');
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Error recording transaction.');
        }
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
    public function update(UpdatePettyCashRequest $request, PettyCash $pettyCash)
    {
        $validated = $request->validated();

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

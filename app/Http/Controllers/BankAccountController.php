<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view bank accounts')->only(['index', 'show']);
        $this->middleware('permission:create bank accounts')->only(['create', 'store']);
        $this->middleware('permission:edit bank accounts')->only(['edit', 'update']);
        $this->middleware('permission:delete bank accounts')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = BankAccount::orderBy('name')->paginate(15);
        return view('bank-accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bank-accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number',
            'bank_name' => 'required|string|max:255',
            'currency' => 'required|string|max:3',
            'initial_balance' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['current_balance'] = $validated['initial_balance'];

        BankAccount::create($validated);

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BankAccount $bankAccount)
    {
        $bankAccount->load(['payments.invoice.client']);
        return view('bank-accounts.show', compact('bankAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankAccount $bankAccount)
    {
        return view('bank-accounts.edit', compact('bankAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number,' . $bankAccount->id,
            'bank_name' => 'required|string|max:255',
            'currency' => 'required|string|max:3',
            'description' => 'nullable|string',
        ]);

        $bankAccount->update($validated);

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankAccount $bankAccount)
    {
        // Check if account has transactions
        if ($bankAccount->payments()->count() > 0) {
            return redirect()->route('bank-accounts.index')
                ->with('error', 'Cannot delete bank account with existing transactions.');
        }

        $bankAccount->delete();

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank account deleted successfully.');
    }
}

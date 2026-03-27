<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\Client;
use App\Models\Subscription;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $clientId = $request->input('client_id');
        
        $clients = Client::orderBy('name')->get();

        $salesQuery = Sale::with('client', 'service');
        $expensesQuery = Expense::query();
        $newClientsQuery = Client::query();

        if ($startDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $salesQuery->where('sale_date', '>=', $start);
            $expensesQuery->where('expense_date', '>=', $start);
            $newClientsQuery->where('created_at', '>=', $start);
        }

        if ($endDate) {
            $end = Carbon::parse($endDate)->endOfDay();
            $salesQuery->where('sale_date', '<=', $end);
            $expensesQuery->where('expense_date', '<=', $end);
            $newClientsQuery->where('created_at', '<=', $end);
        }

        if ($clientId) {
            $salesQuery->where('client_id', $clientId);
            $selectedClient = Client::find($clientId);
            $expenses = collect(); // Hide expenses for client report
            $newClients = 0;
            $totalExpenses = 0;
        } else {
            $selectedClient = null;
            $expenses = $expensesQuery->get();
            $newClients = $newClientsQuery->count();
            $totalExpenses = $expenses->sum('amount');
        }

        $sales = $salesQuery->orderBy('sale_date', 'desc')->get();
        $totalSales = $sales->sum('amount');
        $netIncome = $totalSales - $totalExpenses;

        return view('reports.index', compact(
            'startDate', 'endDate', 'clients', 'clientId', 'selectedClient',
            'sales', 'expenses', 
            'totalSales', 'totalExpenses', 'netIncome',
            'newClients'
        ));
    }
}

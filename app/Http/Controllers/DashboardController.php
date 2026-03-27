<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Subscription;
use App\Models\Sale;
use App\Models\Expense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        
        $currentMonthSales = Sale::whereMonth('sale_date', Carbon::now()->month)
                                ->whereYear('sale_date', Carbon::now()->year)
                                ->sum('amount');
                                
        $currentMonthExpenses = Expense::whereMonth('expense_date', Carbon::now()->month)
                                    ->whereYear('expense_date', Carbon::now()->year)
                                    ->sum('amount');
                                    
        $netIncome = $currentMonthSales - $currentMonthExpenses;
        
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        
        // Alerts logic
        $expiringSubscriptions = Subscription::with(['client', 'service'])
            ->where('status', 'active')
            ->whereBetween('end_date', [Carbon::now(), Carbon::now()->addDays(7)])
            ->get();
            
        // Chart Data
        // 1. Income over time (Last 6 months)
        $salesData = [];
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            $salesData[] = Sale::whereMonth('sale_date', $date->month)->whereYear('sale_date', $date->year)->sum('amount');
        }
        
        // 2. Client Distribution (Active vs Inactive logic)
        $activeClientsCount = Client::whereHas('subscriptions', function($q) {
            $q->where('status', 'active');
        })->count();
        $inactiveClientsCount = $totalClients - $activeClientsCount;
        
        // 3. Sales by Service
        $servicesSales = Sale::selectRaw('service_id, sum(amount) as total')
            ->whereNotNull('service_id')
            ->groupBy('service_id')
            ->with('service')
            ->get();
            
        $serviceLabels = [];
        $serviceTotals = [];
        foreach($servicesSales as $ss) {
            $serviceLabels[] = $ss->service->name;
            $serviceTotals[] = $ss->total;
        }

        return view('dashboard', compact(
            'totalClients', 
            'currentMonthSales', 
            'netIncome', 
            'activeSubscriptions', 
            'expiringSubscriptions',
            'months', 'salesData',
            'activeClientsCount', 'inactiveClientsCount',
            'serviceLabels', 'serviceTotals'
        ));
    }
}

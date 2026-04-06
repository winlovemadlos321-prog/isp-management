<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('is_active', true)->count();
        $monthlyRevenue = Payment::whereMonth('payment_date', now()->month)->sum('amount');
        $totalRevenue = Payment::sum('amount');
        $recentPayments = Payment::with('customer')->latest()->take(10)->get();
        $expiringCustomers = Customer::whereMonth('expiry_date', now()->month)
            ->where('is_active', true)
            ->count();
        
        return view('admin.dashboard', compact(
            'totalCustomers',
            'activeCustomers', 
            'monthlyRevenue',
            'totalRevenue',
            'recentPayments',
            'expiringCustomers'
        ));
    }
    
    public function justRuns()
    {
        return view('admin.just-runs');
    }
    
    public function loans()
    {
        return view('admin.loans');
    }
    
    public function outers()
    {
        return view('admin.outers');
    }
    
    public function reports()
    {
        $monthlyRevenue = Payment::selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->whereYear('payment_date', now()->year)
            ->groupBy('month')
            ->get();
            
        return view('admin.reports', compact('monthlyRevenue'));
    }
}
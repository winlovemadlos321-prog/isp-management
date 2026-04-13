<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Router;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'active_customers' => Customer::where('is_active', true)->count(),
            'synced_customers' => Customer::where('status', 'synced')->count(),
            'unsynced_customers' => Customer::where('status', 'unsynced')->count(),
            'total_plans' => Plan::count(),
            'total_routers' => Router::where('is_active', true)->count(),
            'monthly_revenue' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
            'expiring_soon' => Customer::where('expiry_date', '<=', now()->addDays(7))
                                        ->where('is_active', true)
                                        ->count()
        ];
        
        $recentCustomers = Customer::with('router')->latest()->take(5)->get();
        $recentPayments = Payment::with('customer')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentCustomers', 'recentPayments'));
    }
}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tachometer-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">GameTech ISP</h1>
                            <p class="text-xs text-gray-500">Management System</p>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-users mr-2"></i>Customers
                        </a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-chart-line mr-2"></i>Analytics
                        </a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-500 text-xl cursor-pointer hover:text-blue-600 transition"></i>
                        <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-800 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 mb-8 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-blue-100">Here's what's happening with your ISP network today.</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-chart-line text-6xl text-blue-300"></i>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Customers -->
            <div class="bg-white rounded-2xl shadow-lg p-6 stat-card cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ \App\Models\Customer::count() }}</span>
                </div>
                <h3 class="text-gray-600 font-medium">Total Customers</h3>
                <p class="text-sm text-gray-400 mt-2">
                    <i class="fas fa-arrow-up text-green-500"></i> +12% from last month
                </p>
            </div>

            <!-- Monthly Revenue -->
            <div class="bg-white rounded-2xl shadow-lg p-6 stat-card cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-peso-sign text-orange-600 text-xl"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">₱{{ number_format(\App\Models\Payment::whereMonth('payment_date', now()->month)->sum('amount'), 0) }}</span>
                </div>
                <h3 class="text-gray-600 font-medium">Monthly Revenue</h3>
                <p class="text-sm text-gray-400 mt-2">
                    <i class="fas fa-arrow-up text-green-500"></i> +8% from last month
                </p>
            </div>

            <!-- Active Customers -->
            <div class="bg-white rounded-2xl shadow-lg p-6 stat-card cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-yellow-600 text-xl"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ \App\Models\Customer::where('is_active', true)->count() }}</span>
                </div>
                <h3 class="text-gray-600 font-medium">Active Customers</h3>
                <p class="text-sm text-gray-400 mt-2">
                    <i class="fas fa-chart-line text-blue-500"></i> Network active
                </p>
            </div>

            <!-- Expiring Soon -->
            <div class="bg-white rounded-2xl shadow-lg p-6 stat-card cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ \App\Models\Customer::whereMonth('expiry_date', now()->month)->where('is_active', true)->count() }}</span>
                </div>
                <h3 class="text-gray-600 font-medium">Expiring This Month</h3>
                <p class="text-sm text-gray-400 mt-2">
                    <i class="fas fa-clock text-orange-500"></i> Need attention
                </p>
            </div>
        </div>

        <!-- Charts and Data Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>Revenue Overview
                    </h3>
                    <select class="text-sm border rounded-lg px-3 py-1 focus:outline-none focus:border-blue-500">
                        <option>This Month</option>
                        <option>Last Month</option>
                        <option>This Year</option>
                    </select>
                </div>
                <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                    <canvas id="revenueChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">
                    <i class="fas fa-history text-orange-600 mr-2"></i>Recent Activities
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">New customer registered</p>
                            <p class="text-xs text-gray-500">John Doe joined Premium plan</p>
                        </div>
                        <span class="text-xs text-gray-400">5 mins ago</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-orange-50 rounded-lg">
                        <div class="w-10 h-10 bg-orange-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-credit-card text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">Payment received</p>
                            <p class="text-xs text-gray-500">$79.99 from Sarah Smith</p>
                        </div>
                        <span class="text-xs text-gray-400">1 hour ago</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg">
                        <div class="w-10 h-10 bg-yellow-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-tools text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">Installation completed</p>
                            <p class="text-xs text-gray-500">New router installed for Mike Johnson</p>
                        </div>
                        <span class="text-xs text-gray-400">3 hours ago</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payments Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-orange-50">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-receipt text-blue-600 mr-2"></i>Recent Transactions
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\Payment::with('customer')->latest()->take(10)->get() as $payment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">{{ $payment->receipt_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->customer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->customer->plan->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">${{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->is_reconciled)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Completed
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Revenue',
                data: [12500, 15000, 18000, 22000],
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endsection
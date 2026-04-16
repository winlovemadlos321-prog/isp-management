@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('layouts.sidebar')
    
    <!-- Main Content Area -->
    <div class="flex-1 ml-64">
        <!-- Top Navigation Bar --> 
        @include('layouts.topbar')

        <!-- Main Content -->
        <div class="mt-10 py-8 px-4 sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-500 via-blue-600 via-10% to-blue-800 rounded-2xl p-8 mb-8 text-white">
                <div class="flex justify-between items-center">
                    <div>   
                        <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                        <p class="text-white">Here's what's happening with your ISP network today.</p>
                    </div>
                    <div class="hidden md:block">
                        <i class="fas fa-chart-line text-6xl text-white/70"></i>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->   
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Customers -->
                <div class="bg-white rounded-2xl shadow-lg p-6 stat-card cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-orange-500 text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-gray-800">{{ \App\Models\Customer::count() }}</span>
                    </div>
                    <h3 class="text-orange-500 font-medium">Total Customers</h3>
                    <p class="text-sm text-gray-400 mt-2">
                        <i class="fas fa-arrow-up text-green-500"></i> +12% from last month
                    </p>
                </div>

                <!-- Monthly Revenue (FIXED - uses real payment data) -->
                <div class="bg-white rounded-2xl shadow-lg p-6 stat-card cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-peso-sign text-orange-500 text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-gray-800">
                            ₱{{ number_format(\App\Models\Payment::whereMonth('payment_date', now()->month)->whereYear('payment_date', now()->year)->sum('amount'), 2) }}
                        </span>
                    </div>
                    <h3 class="text-orange-500 font-medium">Monthly Revenue</h3>
                    <p class="text-sm text-gray-400 mt-2">
                        <i class="fas fa-calendar-alt text-blue-500"></i> {{ now()->format('F Y') }}
                    </p>
                </div>

                <!-- Active Customers -->
                <div class="bg-white rounded-2xl shadow-lg p-6 stat-card cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-orange-500 text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-gray-800">{{ \App\Models\Customer::where('is_active', true)->count() }}</span>
                    </div>
                    <h3 class="text-orange-500 font-medium">Active Customers</h3>
                    <p class="text-sm text-gray-400 mt-2">
                        <i class="fas fa-chart-line text-blue-500"></i> Network active
                    </p>
                </div>

                <!-- Expiring Soon (FIXED - uses customer expiry dates) -->
                <div class="bg-white rounded-2xl shadow-lg p-6 stat-card cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-gray-800">
                            {{ \App\Models\Customer::where('expiry_date', '>=', now()->startOfMonth())
                                ->where('expiry_date', '<=', now()->endOfMonth())
                                ->where('is_active', true)
                                ->count() }}
                        </span>
                    </div>
                    <h3 class="text-orange-500 font-medium">Expiring This Month</h3>
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
                            <i class="fas fa-chart-line text-orange-500 mr-2"></i>Revenue Overview
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
                        <i class="fas fa-history text-orange-500 mr-2"></i>Recent Activities
                    </h3>
                    <div class="space-y-4">
                        @php
                            $recentCustomers = \App\Models\Customer::latest()->take(3)->get();
                            $recentPayments = \App\Models\Payment::with('customer')->latest()->take(3)->get();
                        @endphp
                        
                        @foreach($recentCustomers as $customer)
                        <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-plus text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">New customer registered</p>
                                <p class="text-xs text-gray-500">{{ $customer->name }} - {{ $customer->plan_name }} plan</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $customer->created_at->diffForHumans() }}</span>
                        </div>
                        @endforeach
                        
                        @foreach($recentPayments as $payment)
                        <div class="flex items-center space-x-3 p-3 bg-orange-50 rounded-lg">
                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-credit-card text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Payment received</p>
                                <p class="text-xs text-gray-500">₱{{ number_format($payment->amount, 2) }} from {{ $payment->customer->name ?? 'N/A' }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $payment->created_at->diffForHumans() }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Payments Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-orange-50">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-receipt text-orange-500 mr-2"></i>Recent Transactions
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
                            @forelse(\App\Models\Payment::with('customer')->latest()->take(10)->get() as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-500">{{ $payment->receipt_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->customer->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->customer->plan_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($payment->is_reconciled ?? false)
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
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    No payments recorded yet
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                label: 'Revenue (₱)',
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
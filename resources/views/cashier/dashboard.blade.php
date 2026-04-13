@extends('layouts.cashier')

@section('title', 'Cashier Dashboard')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl p-8 mb-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold mb-2">Welcome, {{ auth()->user()->name }}!</h2>
                <p class="text-orange-100">Manage payments and customer transactions efficiently.</p>
            </div>
            <i class="fas fa-cash-register text-6xl text-orange-200"></i>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Today's Collection</p>
                    <p class="text-3xl font-bold text-green-600">₱{{ number_format($todayPayments ?? 0, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">This Month's Collection</p>
                    <p class="text-3xl font-bold text-blue-600">₱{{ number_format($monthlyPayments ?? 0, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Customers</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $totalCustomers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-orange-50 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-receipt text-orange-500 mr-2"></i>Recent Payments
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receipt #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentPayments ?? [] as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-500">{{ $payment->receipt_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->customer->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">₱{{ number_format($payment->amount ?? 0, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100">
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ isset($payment->payment_date) ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if(isset($payment))
                            <a href="{{ route('cashier.payments.receipt', $payment) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-print"></i> Print
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-receipt fa-3x mb-2"></i>
                            <p>No payments recorded yet</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <a href="{{ route('cashier.payments.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white hover:shadow-xl transition-all">
            <i class="fas fa-receipt text-3xl mb-3"></i>
            <h3 class="text-xl font-bold mb-2">Record Payment</h3>
            <p class="text-green-100 text-sm">Process customer payment</p>
        </a>
        
        <a href="{{ route('cashier.customers.index') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white hover:shadow-xl transition-all">
            <i class="fas fa-users text-3xl mb-3"></i>
            <h3 class="text-xl font-bold mb-2">View Customers</h3>
            <p class="text-blue-100 text-sm">Browse all customers</p>
        </a>
        
        <a href="{{ route('cashier.payments.history') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white hover:shadow-xl transition-all">
            <i class="fas fa-history text-3xl mb-3"></i>
            <h3 class="text-xl font-bold mb-2">Payment History</h3>
            <p class="text-orange-100 text-sm">View all transactions</p>
        </a>
    </div>
</div>
@endsection
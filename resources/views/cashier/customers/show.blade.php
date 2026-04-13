@extends('layouts.cashier')

@section('title', 'Customer Details')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-orange-50 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-user text-orange-500 mr-2"></i>Customer Details
                </h2>
                <a href="{{ route('cashier.customers.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm text-gray-500">Customer Number</label>
                    <p class="text-lg font-semibold text-orange-600">{{ $customer->customer_number }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Full Name</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $customer->name }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Phone</label>
                    <p class="text-gray-800">{{ $customer->phone }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Email</label>
                    <p class="text-gray-800">{{ $customer->email ?? 'N/A' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-500">Address</label>
                    <p class="text-gray-800">{{ $customer->address }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Plan</label>
                    <p class="text-gray-800 font-medium">{{ $customer->plan_name }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Monthly Fee</label>
                    <p class="text-green-600 font-bold">₱{{ number_format($customer->plan_price, 2) }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Device Type</label>
                    <p class="text-gray-800">{{ $customer->device }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Expiry Date</label>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($customer->expiry_date)->format('F d, Y') }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Status</label>
                    @if($customer->is_active)
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </div>
            </div>
            
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('cashier.payments.create') }}?customer={{ $customer->id }}" 
                   class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-lg hover:from-orange-600 transition">
                    <i class="fas fa-receipt mr-2"></i>Record Payment
                </a>
                <a href="{{ route('cashier.customers.payments', $customer) }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-history mr-2"></i>View Payment History
                </a>
            </div>
        </div>
    </div>
    
    <!-- Recent Payments -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-orange-500">{{ $payment->receipt_number }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">₱{{ number_format($payment->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td class="px-6 py-4 text-sm">{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('cashier.payments.receipt', $payment) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-print"></i> Print
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No payments recorded</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
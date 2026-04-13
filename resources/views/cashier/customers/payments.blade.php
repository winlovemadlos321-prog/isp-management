@extends('layouts.cashier')

@section('title', 'Payment History - ' . $customer->name)

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-orange-50 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-history text-orange-500 mr-2"></i>Payment History - {{ $customer->name }}
                </h2>
                <a href="{{ route('cashier.customers.show', $customer) }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Customer
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receipt #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-orange-500">{{ $payment->receipt_number }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">₱{{ number_format($payment->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td class="px-6 py-4 text-sm">{{ $payment->payment_date->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4 text-sm">{{ $payment->reference_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('cashier.payments.receipt', $payment) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-print"></i> Reprint
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-receipt fa-3x mb-2"></i>
                            <p>No payment records found for this customer</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
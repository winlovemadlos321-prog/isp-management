@extends('layouts.cashier')

@section('title', 'Customers')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-orange-50 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-users text-orange-500 mr-2"></i>Customer List
                </h2>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInput" placeholder="Live search by name, #, or phone..." 
                           class="pl-9 pr-3 py-1.5 border rounded-lg focus:outline-none focus:border-orange-500 text-sm w-64">
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody id="customersTableBody" class="bg-white divide-y divide-gray-200">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50 transition customer-row" 
                        data-name="{{ strtolower($customer->name) }}"
                        data-phone="{{ strtolower($customer->phone) }}"
                        data-number="{{ strtolower($customer->customer_number) }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-500">{{ $customer->customer_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">{{ substr($customer->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-gray-900">{{ $customer->plan_name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($customer->expiry_date)->format('M d, Y') }}
                            @if($customer->expiry_date < now())
                                <span class="text-red-500 text-xs ml-1">Expired</span>
                            @elseif($customer->expiry_date <= now()->addDays(7))
                                <span class="text-yellow-500 text-xs ml-1">Expiring soon</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($customer->is_active)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('cashier.customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('cashier.customers.payments', $customer) }}" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-history"></i> Payments
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr id="noResultsRow">
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-users fa-3x mb-2"></i>
                            <p>No customers found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200" id="paginationLinks">
            {{ $customers->links() }}
        </div>
    </div>
</div>

<script>
    let searchTimeout;
    let allCustomers = [];
    
    // Store all customer data from PHP
    const customersData = @json($customers->items());
    
    // Store the original table HTML for reset
    let originalTableHtml = '';
    
    document.addEventListener('DOMContentLoaded', function() {
        // Store original table content
        const tbody = document.getElementById('customersTableBody');
        if (tbody) {
            originalTableHtml = tbody.innerHTML;
        }
        
        // Store all customers for filtering
        allCustomers = customersData;
    });
    
    // LIVE SEARCH - as you type
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performLiveSearch(e.target.value.toLowerCase());
        }, 300);
    });
    
    function performLiveSearch(searchTerm) {
        const tbody = document.getElementById('customersTableBody');
        const paginationDiv = document.getElementById('paginationLinks');
        
        if (!searchTerm || searchTerm === '') {
            // Reset to original view
            if (originalTableHtml) {
                tbody.innerHTML = originalTableHtml;
            }
            if (paginationDiv) {
                paginationDiv.innerHTML = `{{ $customers->links() }}`;
            }
            return;
        }
        
        // Filter customers
        const filtered = allCustomers.filter(customer => 
            customer.name.toLowerCase().includes(searchTerm) ||
            customer.phone.toLowerCase().includes(searchTerm) ||
            customer.customer_number.toLowerCase().includes(searchTerm)
        );
        
        // Hide pagination when searching
        if (paginationDiv) {
            paginationDiv.innerHTML = '';
        }
        
        if (filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-search fa-3x mb-2"></i>
                        <p>No customers found matching "${searchTerm}"</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        // Build table HTML
        tbody.innerHTML = filtered.map(customer => `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-500">${escapeHtml(customer.customer_number)}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">${escapeHtml(customer.name.charAt(0))}</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">${escapeHtml(customer.name)}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${escapeHtml(customer.phone)}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-medium text-gray-900">${escapeHtml(customer.plan_name)}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    ${formatDate(customer.expiry_date)}
                    ${isExpiringSoon(customer.expiry_date)}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${customer.is_active ? 
                        '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>' : 
                        '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactive</span>'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="/cashier/customers/${customer.id}" class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="/cashier/customers/${customer.id}/payments" class="text-green-600 hover:text-green-900">
                        <i class="fas fa-history"></i> Payments
                    </a>
                </td>
            </tr>
        `).join('');
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }
    
    function isExpiringSoon(dateString) {
        const expiryDate = new Date(dateString);
        const today = new Date();
        const sevenDaysFromNow = new Date();
        sevenDaysFromNow.setDate(today.getDate() + 7);
        
        if (expiryDate < today) {
            return '<span class="text-red-500 text-xs ml-1">Expired</span>';
        } else if (expiryDate <= sevenDaysFromNow) {
            return '<span class="text-yellow-500 text-xs ml-1">Expiring soon</span>';
        }
        return '';
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endsection
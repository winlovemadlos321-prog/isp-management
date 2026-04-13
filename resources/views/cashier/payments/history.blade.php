@extends('layouts.cashier')

@section('title', 'Payment History')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header with Filters -->
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-orange-50 border-b border-gray-200">
            <div class="flex flex-wrap justify-between items-center gap-3">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-history text-orange-500 mr-2"></i>Payment History
                </h2>
                
                <!-- Filter Tabs -->
                <div class="flex gap-2">
                    <button onclick="setFilter('today')" id="filterToday" class="px-4 py-1.5 text-sm rounded-lg transition bg-gray-200 text-gray-700 hover:bg-gray-300">
                        <i class="fas fa-calendar-day mr-1"></i> Today
                    </button>
                    <button onclick="setFilter('weekly')" id="filterWeekly" class="px-4 py-1.5 text-sm rounded-lg transition bg-gray-200 text-gray-700 hover:bg-gray-300">
                        <i class="fas fa-calendar-week mr-1"></i> This Week
                    </button>
                    <button onclick="setFilter('monthly')" id="filterMonthly" class="px-4 py-1.5 text-sm rounded-lg transition bg-gray-200 text-gray-700 hover:bg-gray-300">
                        <i class="fas fa-calendar-alt mr-1"></i> This Month
                    </button>
                    <button onclick="setFilter('yearly')" id="filterYearly" class="px-4 py-1.5 text-sm rounded-lg transition bg-gray-200 text-gray-700 hover:bg-gray-300">
                        <i class="fas fa-calendar-year mr-1"></i> This Year
                    </button>
                    <button onclick="setFilter('all')" id="filterAll" class="px-4 py-1.5 text-sm rounded-lg transition bg-orange-500 text-white shadow-sm">
                        <i class="fas fa-list mr-1"></i> All
                    </button>
                </div>
            </div>
            
            <!-- Date Range Picker and Search -->
            <div class="flex flex-wrap justify-between items-center gap-3 mt-4">
                <div class="flex gap-2 items-center">
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                        <input type="date" id="startDate" class="pl-9 pr-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                    </div>
                    <span class="text-gray-500 text-sm">to</span>
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                        <input type="date" id="endDate" class="pl-9 pr-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                    </div>
                    <button onclick="filterByDateRange()" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1.5 rounded-lg transition text-sm">
                        <i class="fas fa-filter"></i> Apply
                    </button>
                    <button onclick="resetFilters()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1.5 rounded-lg transition text-sm">
                        <i class="fas fa-undo-alt"></i> Reset
                    </button>
                </div>
                
                <div class="flex gap-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                        <input type="text" id="searchInput" placeholder="Search by customer, receipt" 
                               class="pl-9 pr-3 py-1.5 border rounded-lg focus:outline-none focus:border-orange-500 text-sm w-64">
                    </div>
                </div>
            </div>
            
            <!-- Summary Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4 pt-3 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-xs text-gray-500">Total Transactions</p>
                    <p class="text-lg font-bold text-gray-800" id="totalTransactions">0</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">Total Amount</p>
                    <p class="text-lg font-bold text-green-600" id="totalAmount">₱0.00</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">Average Payment</p>
                    <p class="text-lg font-bold text-blue-600" id="avgAmount">₱0.00</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">Date Range</p>
                    <p class="text-sm font-medium text-orange-600" id="dateRangeLabel">All Time</p>
                </div>
            </div>
        </div>
        
        <!-- Payments Table -->
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
                <tbody id="paymentsTableBody" class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-500">{{ $payment->receipt_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->customer->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">₱{{ number_format($payment->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100">
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->payment_date->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('cashier.payments.receipt', $payment) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-print"></i> Reprint
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr id="noResultsRow">
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-receipt fa-3x mb-2"></i>
                            <p>No payment records found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $payments->links() }}
        </div>
    </div>
</div>

<script>
    let currentFilter = 'all';
    let allPayments = [];
    let searchTimeout;
    
    // Store all payment data from PHP
    const paymentsData = @json($payments->items());
    
    // Set today's date as default for date pickers
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const firstDayOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
        
        if (document.getElementById('startDate')) {
            document.getElementById('startDate').value = firstDayOfMonth;
        }
        if (document.getElementById('endDate')) {
            document.getElementById('endDate').value = today;
        }
        
        updateStats(paymentsData);
        updateTable(paymentsData);
    });
    
    // LIVE SEARCH - as you type
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterAndDisplay();
        }, 300); // 300ms debounce for better performance
    });
    
    function setFilter(filter) {
        currentFilter = filter;
        
        // Update button styles
        const buttons = ['filterToday', 'filterWeekly', 'filterMonthly', 'filterYearly', 'filterAll'];
        buttons.forEach(btn => {
            const element = document.getElementById(btn);
            if (element) {
                element.classList.remove('bg-orange-500', 'text-white');
                element.classList.add('bg-gray-200', 'text-gray-700');
            }
        });
        
        const activeButton = document.getElementById(`filter${filter.charAt(0).toUpperCase() + filter.slice(1)}`);
        if (activeButton) {
            activeButton.classList.remove('bg-gray-200', 'text-gray-700');
            activeButton.classList.add('bg-orange-500', 'text-white');
        }
        
        filterAndDisplay();
    }
    
    function filterAndDisplay() {
        let filtered = [...paymentsData];
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        const startOfWeek = new Date(today);
        startOfWeek.setDate(today.getDate() - today.getDay());
        
        const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        const startOfYear = new Date(today.getFullYear(), 0, 1);
        
        // Apply date filter
        filtered = filtered.filter(payment => {
            const paymentDate = new Date(payment.payment_date);
            paymentDate.setHours(0, 0, 0, 0);
            
            switch(currentFilter) {
                case 'today':
                    return paymentDate.getTime() === today.getTime();
                case 'weekly':
                    return paymentDate >= startOfWeek;
                case 'monthly':
                    return paymentDate >= startOfMonth;
                case 'yearly':
                    return paymentDate >= startOfYear;
                default:
                    return true;
            }
        });
        
        // Apply LIVE search filter
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase().trim() || '';
        if (searchTerm) {
            filtered = filtered.filter(payment => 
                (payment.customer?.name || '').toLowerCase().includes(searchTerm) ||
                (payment.receipt_number || '').toLowerCase().includes(searchTerm) ||
                (payment.payment_method || '').toLowerCase().includes(searchTerm)
            );
        }
        
        updateTable(filtered);
        updateStats(filtered);
        updateDateRangeLabel();
    }
    
    function filterByDateRange() {
        const startDate = document.getElementById('startDate')?.value;
        const endDate = document.getElementById('endDate')?.value;
        
        if (!startDate && !endDate) return;
        
        let filtered = [...paymentsData];
        
        if (startDate) {
            const start = new Date(startDate);
            start.setHours(0, 0, 0, 0);
            filtered = filtered.filter(payment => new Date(payment.payment_date) >= start);
        }
        
        if (endDate) {
            const end = new Date(endDate);
            end.setHours(23, 59, 59, 999);
            filtered = filtered.filter(payment => new Date(payment.payment_date) <= end);
        }
        
        // Apply search filter if any
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase().trim() || '';
        if (searchTerm) {
            filtered = filtered.filter(payment => 
                (payment.customer?.name || '').toLowerCase().includes(searchTerm) ||
                (payment.receipt_number || '').toLowerCase().includes(searchTerm)
            );
        }
        
        updateTable(filtered);
        updateStats(filtered);
        
        // Update label
        const label = document.getElementById('dateRangeLabel');
        if (label) {
            if (startDate && endDate) {
                label.textContent = `${startDate} to ${endDate}`;
            } else if (startDate) {
                label.textContent = `From ${startDate}`;
            } else if (endDate) {
                label.textContent = `Until ${endDate}`;
            }
        }
        
        // Reset filter buttons styling
        const buttons = ['filterToday', 'filterWeekly', 'filterMonthly', 'filterYearly', 'filterAll'];
        buttons.forEach(btn => {
            const element = document.getElementById(btn);
            if (element) {
                element.classList.remove('bg-orange-500', 'text-white');
                element.classList.add('bg-gray-200', 'text-gray-700');
            }
        });
        currentFilter = 'custom';
    }
    
    function updateTable(filtered) {
        const tbody = document.getElementById('paymentsTableBody');
        if (!tbody) return;
        
        if (filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-receipt fa-3x mb-2"></i>
                        <p>No payment records found</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = filtered.map(payment => `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-500">${escapeHtml(payment.receipt_number || 'N/A')}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${escapeHtml(payment.customer?.name || 'N/A')}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">₱${parseFloat(payment.amount).toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100">
                        ${escapeHtml(payment.payment_method ? payment.payment_method.charAt(0).toUpperCase() + payment.payment_method.slice(1).replace('_', ' ') : 'N/A')}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(payment.payment_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="/cashier/payments/${payment.id}/receipt" target="_blank" class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-print"></i> Reprint
                    </a>
                 </td>
             </tr>
        `).join('');
    }
    
    function updateStats(filtered) {
        const total = filtered.length;
        const sum = filtered.reduce((acc, p) => acc + parseFloat(p.amount), 0);
        const avg = total > 0 ? sum / total : 0;
        
        const totalTransactionsEl = document.getElementById('totalTransactions');
        const totalAmountEl = document.getElementById('totalAmount');
        const avgAmountEl = document.getElementById('avgAmount');
        
        if (totalTransactionsEl) totalTransactionsEl.textContent = total;
        if (totalAmountEl) totalAmountEl.textContent = `₱${sum.toFixed(2)}`;
        if (avgAmountEl) avgAmountEl.textContent = `₱${avg.toFixed(2)}`;
    }
    
    function updateDateRangeLabel() {
        const label = document.getElementById('dateRangeLabel');
        if (!label) return;
        
        switch(currentFilter) {
            case 'today': label.textContent = 'Today'; break;
            case 'weekly': label.textContent = 'This Week'; break;
            case 'monthly': label.textContent = 'This Month'; break;
            case 'yearly': label.textContent = 'This Year'; break;
            case 'all': label.textContent = 'All Time'; break;
            default: label.textContent = 'Custom Range';
        }
    }
    
    function resetFilters() {
        currentFilter = 'all';
        
        // Reset button styles
        const buttons = ['filterToday', 'filterWeekly', 'filterMonthly', 'filterYearly', 'filterAll'];
        buttons.forEach(btn => {
            const element = document.getElementById(btn);
            if (element) {
                element.classList.remove('bg-orange-500', 'text-white');
                element.classList.add('bg-gray-200', 'text-gray-700');
            }
        });
        
        const allButton = document.getElementById('filterAll');
        if (allButton) {
            allButton.classList.remove('bg-gray-200', 'text-gray-700');
            allButton.classList.add('bg-orange-500', 'text-white');
        }
        
        // Reset search input
        if (document.getElementById('searchInput')) {
            document.getElementById('searchInput').value = '';
        }
        
        // Reset date pickers to default
        const today = new Date().toISOString().split('T')[0];
        const firstDayOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
        
        if (document.getElementById('startDate')) {
            document.getElementById('startDate').value = firstDayOfMonth;
        }
        if (document.getElementById('endDate')) {
            document.getElementById('endDate').value = today;
        }
        
        filterAndDisplay();
    }
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endsection
@extends('layouts.cashier')

@section('title', 'Record Payment')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="w-full">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Record Payment</h1>
            <p class="text-gray-500 text-sm mt-1">Process customer payment and generate receipt</p>
        </div>

        <!-- Success Message Display -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <div class="flex items-center">
                <div class="bg-green-500 rounded-full p-1 mr-3">
                    <i class="fas fa-check-circle text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-green-800">Payment Successful!</p>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.closest('.bg-green-100').style.display='none'" class="text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Error Message Display -->
        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <div class="flex items-center">
                <div class="bg-red-500 rounded-full p-1 mr-3">
                    <i class="fas fa-exclamation-circle text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-red-800">Payment Failed!</p>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.closest('.bg-red-100').style.display='none'" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Search Customer Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-search text-orange-500 mr-2"></i>Search Customer<span class="text-sm font-normal italic text-gray-400 ml-2">(input customer name and select from the lists)</span>
                </h2>
            </div>
            <div class="p-6">
                <div class="flex gap-3">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" id="searchCustomer" 
                               placeholder="Type to search by name, customer #, or phone..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                    </div>
                    <button onclick="clearSearch()" id="clearSearchBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition flex items-center gap-2 hidden">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
                
                <!-- Customer Search Results -->
                <div id="searchResults" class="mt-4 hidden">
                    <div class="border rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Customer #</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Phone</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Plan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Action</th>
                                </tr>
                            </thead>
                            <tbody id="searchResultsTable">
                                <!-- Results will appear here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Loading indicator -->
                <div id="searchLoading" class="text-center py-4 hidden">
                    <i class="fas fa-spinner fa-spin text-orange-500 text-xl"></i>
                    <p class="text-gray-500 text-sm mt-1">Searching...</p>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-receipt text-orange-500 mr-2"></i>Payment Details
                </h2>
            </div>
            
            <form action="{{ route('cashier.payments.store') }}" method="POST" class="p-6">
                @csrf
                
                <!-- Selected Customer Info -->
                <div id="selectedCustomerInfo" class="bg-gradient-to-r from-blue-50 to-orange-50 rounded-xl p-4 mb-6 hidden">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Selected Customer</p>
                            <p class="text-lg font-bold text-gray-800" id="selectedCustomerName">-</p>
                            <div class="flex flex-wrap gap-4 mt-2 text-sm">
                                <span><span class="text-gray-500">Customer #:</span> <span id="selectedCustomerNumber" class="font-medium">-</span></span>
                                <span><span class="text-gray-500">Phone:</span> <span id="selectedCustomerPhone" class="font-medium">-</span></span>
                                <span><span class="text-gray-500">Plan:</span> <span id="selectedPlanName" class="font-medium">-</span></span>
                                <span><span class="text-gray-500">Monthly Fee:</span> <span id="selectedPlanPrice" class="font-medium text-green-600">-</span></span>
                                <span><span class="text-gray-500">Expiry Date:</span> <span id="selectedExpiryDate" class="font-medium text-red-500">-</span></span>
                            </div>
                        </div>
                        <button type="button" onclick="clearSelectedCustomer()" class="text-gray-400 hover:text-red-500">
                            <i class="fas fa-times-circle text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <input type="hidden" name="customer_id" id="customer_id" value="">
                <input type="hidden" name="current_expiry_date" id="current_expiry_date" value="">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amount *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">₱</span>
                            <input type="number" name="amount" id="amount" required step="0.01" 
                                class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" 
                                placeholder="0.00">
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                        <select name="payment_method" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                            <option value="cash">💵 Cash</option>
                            <option value="card">💳 Card</option>
                            <option value="bank_transfer">🏦 Bank Transfer</option>
                            <option value="gcash">📱 GCash</option>
                        </select>
                    </div>
                    
                    <!-- Payment Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date *</label>
                        <input type="date" name="payment_date" id="payment_date" required value="{{ date('Y-m-d') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                    </div>
                    
                    <!-- Payment For Month -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment For Month *</label>
                        <select name="payment_for_month" id="payment_for_month" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            <option value="">Select Month</option>
                        </select>
                    </div>
                    
                    <!-- Reference Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                        <input type="text" name="reference_number" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" 
                               placeholder="For bank transfer or GCash reference">
                    </div>
                    
                    <!-- Extend Months -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Extend Subscription (Months)</label>
                        <select name="extend_months" id="extend_months" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            <option value="1">1 Month</option>
                            <option value="2">2 Months</option>
                            <option value="3">3 Months</option>
                            <option value="6">6 Months</option>
                            <option value="12">12 Months</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">New expiry date will be extended by selected months</p>
                    </div>
                    
                    <!-- New Expiry Date Preview -->
                    <div id="newExpiryPreview" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Expiry Date</label>
                        <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                            <p class="text-sm font-semibold text-green-700">
                                <i class="fas fa-calendar-check mr-1"></i>
                                <span id="newExpiryDate"></span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" 
                            placeholder="Additional notes..."></textarea>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('cashier.dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition shadow-sm hover:shadow-md">
                        <i class="fas fa-save mr-2"></i>Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let searchTimeout;
    let allCustomers = [];
    
    // Generate months for dropdown (current month + next 11 months)
    function generateMonthOptions() {
        const months = [];
        const currentDate = new Date();
        
        for (let i = 0; i < 12; i++) {
            const date = new Date(currentDate.getFullYear(), currentDate.getMonth() + i, 1);
            const monthValue = date.toISOString().slice(0, 7); // YYYY-MM
            const monthName = date.toLocaleString('default', { month: 'long', year: 'numeric' });
            months.push({ value: monthValue, name: monthName });
        }
        
        return months;
    }
    
    // Populate month dropdown
    function populateMonths() {
        const monthSelect = document.getElementById('payment_for_month');
        const months = generateMonthOptions();
        
        monthSelect.innerHTML = '<option value="">Select Month</option>';
        months.forEach(month => {
            const option = document.createElement('option');
            option.value = month.value;
            option.textContent = month.name;
            monthSelect.appendChild(option);
        });
    }
    
    // Calculate new expiry date
    function calculateNewExpiryDate(currentExpiryDate, extendMonths) {
        if (!currentExpiryDate) return null;
        const date = new Date(currentExpiryDate);
        date.setMonth(date.getMonth() + parseInt(extendMonths));
        return date;
    }
    
    // Format date to readable format
    function formatDate(date) {
        if (!date) return 'N/A';
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }
    
    // Update expiry preview
    function updateExpiryPreview() {
        const currentExpiry = document.getElementById('current_expiry_date').value;
        const extendMonths = document.getElementById('extend_months').value;
        const previewDiv = document.getElementById('newExpiryPreview');
        
        if (currentExpiry && extendMonths) {
            const newDate = calculateNewExpiryDate(new Date(currentExpiry), extendMonths);
            if (newDate) {
                document.getElementById('newExpiryDate').innerHTML = formatDate(newDate);
                previewDiv.classList.remove('hidden');
            }
        } else {
            previewDiv.classList.add('hidden');
        }
    }
    
    // Load all customers data on page load
    document.addEventListener('DOMContentLoaded', function() {
        populateMonths();
        
        const select = document.getElementById('customerSelect');
        if (select) {
            for (let i = 0; i < select.options.length; i++) {
                const option = select.options[i];
                if (option.value) {
                    allCustomers.push({
                        id: option.value,
                        number: option.getAttribute('data-number'),
                        name: option.text.split(' - ')[1]?.split(' (')[0] || option.text,
                        phone: option.getAttribute('data-phone') || 'N/A',
                        plan: option.getAttribute('data-plan'),
                        price: option.getAttribute('data-price'),
                        expiry: option.getAttribute('data-expiry') || null
                    });
                }
            }
        }
        
        // Hide the original select
        const originalSelect = document.querySelector('select[name="customer_id"]');
        if (originalSelect) {
            originalSelect.style.display = 'none';
        }
        
        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            const successAlert = document.querySelector('.bg-green-100');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 500);
            }
            
            const errorAlert = document.querySelector('.bg-red-100');
            if (errorAlert) {
                errorAlert.style.transition = 'opacity 0.5s ease';
                errorAlert.style.opacity = '0';
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 500);
            }
        }, 5000);
    });
    
    // Live search as you type
    document.getElementById('searchCustomer')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const clearBtn = document.getElementById('clearSearchBtn');
        
        if (searchTerm.length > 0) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
            document.getElementById('searchResults').classList.add('hidden');
            return;
        }
        
        if (searchTerm.length < 1) {
            document.getElementById('searchResults').classList.add('hidden');
            return;
        }
        
        // Show loading
        document.getElementById('searchLoading')?.classList.remove('hidden');
        
        // Debounce search for better performance
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(searchTerm);
        }, 300);
    });
    
    function performSearch(searchTerm) {
        const results = allCustomers.filter(customer => 
            customer.name.toLowerCase().includes(searchTerm) ||
            customer.number.toLowerCase().includes(searchTerm) ||
            (customer.phone && customer.phone.toLowerCase().includes(searchTerm))
        );
        
        // Hide loading
        document.getElementById('searchLoading')?.classList.add('hidden');
        
        displaySearchResults(results);
    }
    
    function displaySearchResults(results) {
        const resultsDiv = document.getElementById('searchResults');
        const tableBody = document.getElementById('searchResultsTable');
        
        if (results.length === 0) {
            resultsDiv.classList.add('hidden');
            return;
        }
        
        resultsDiv.classList.remove('hidden');
        tableBody.innerHTML = '';
        
        results.forEach(customer => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 cursor-pointer transition';
            row.onclick = () => selectCustomer(customer);
            row.innerHTML = `
                <td class="px-4 py-2 text-sm text-orange-500 font-medium">${escapeHtml(customer.number)}</td>
                <td class="px-4 py-2 text-sm text-gray-800">${escapeHtml(customer.name)}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${escapeHtml(customer.phone)}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${escapeHtml(customer.plan)}</td>
                <td class="px-4 py-2">
                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded-lg text-xs transition">
                        <i class="fas fa-arrow-right"></i> Select
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
    
    function selectCustomer(customer) {
        // Set the hidden customer_id
        document.getElementById('customer_id').value = customer.id;
        document.getElementById('current_expiry_date').value = customer.expiry;
        
        // Show selected customer info
        const selectedInfo = document.getElementById('selectedCustomerInfo');
        selectedInfo.classList.remove('hidden');
        
        document.getElementById('selectedCustomerName').textContent = customer.name;
        document.getElementById('selectedCustomerNumber').textContent = customer.number;
        document.getElementById('selectedCustomerPhone').textContent = customer.phone;
        document.getElementById('selectedPlanName').textContent = customer.plan;
        document.getElementById('selectedPlanPrice').textContent = '₱' + parseFloat(customer.price).toFixed(2);
        document.getElementById('amount').value = customer.price;
        
        if (customer.expiry) {
            const expiryDate = new Date(customer.expiry);
            document.getElementById('selectedExpiryDate').textContent = formatDate(expiryDate);
        } else {
            document.getElementById('selectedExpiryDate').textContent = 'N/A';
        }
        
        // Update expiry preview
        updateExpiryPreview();
        
        // Hide search results and clear search input
        document.getElementById('searchResults').classList.add('hidden');
        document.getElementById('searchCustomer').value = '';
        document.getElementById('clearSearchBtn').classList.add('hidden');
    }
    
    function clearSearch() {
        document.getElementById('searchCustomer').value = '';
        document.getElementById('searchResults').classList.add('hidden');
        document.getElementById('clearSearchBtn').classList.add('hidden');
    }
    
    function clearSelectedCustomer() {
        document.getElementById('customer_id').value = '';
        document.getElementById('current_expiry_date').value = '';
        document.getElementById('selectedCustomerInfo').classList.add('hidden');
        document.getElementById('amount').value = '';
        document.getElementById('newExpiryPreview').classList.add('hidden');
    }
    
    // Listen for extend months change
    document.getElementById('extend_months')?.addEventListener('change', function() {
        updateExpiryPreview();
    });
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>

<!-- Hidden select with customer data -->
<select name="customer_id_temp" id="customerSelect" style="display: none;">
    <option value="">-- Select Customer --</option>
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}" 
                data-number="{{ $customer->customer_number }}" 
                data-phone="{{ $customer->phone }}"
                data-plan="{{ $customer->plan_name }}" 
                data-price="{{ $customer->plan_price }}"
                data-expiry="{{ $customer->expiry_date }}">
            {{ $customer->customer_number }} - {{ $customer->name }} ({{ $customer->plan_name }})
        </option>
    @endforeach
</select>
@endsection
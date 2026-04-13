@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-800 shadow-xl fixed h-full z-40 top-0 left-0">
        <div class="p-6 border-b border-blue-700">
            <div class="flex items-left space-x-3">   
                <div class="mx-auto h-12 w-12 rounded-full flex items-center justify-center shadow-lg">
                    <img src="{{ asset('asset/logo.png') }}" alt="GameTech Logo" class="rounded-full">
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white"> <span class="text-yellow-400 text-lg">G</span>ameTech</h2>
                    <h2 class="text-lg font-bold text-white">UNLI FIBER</h2>
                    <p class="text-xs text-gray-300">Management System</p>
                </div>
            </div>  
        </div>
        
        <nav class="mt-6 px-4">
            <div class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-user-shield w-5"></i>
                    <span class="font-medium">Users</span>
                </a>
                
                <a href="{{ route('admin.plans.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 {{ request()->routeIs('admin.plans.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span class="font-medium">Plans</span>
                </a>
                
                <a href="{{ route('admin.customers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.customers.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="font-medium">Customers</span>
                </a>
                
                <a href="{{ route('admin.routers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 {{ request()->routeIs('admin.routers.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-server w-5"></i>
                    <span class="font-medium">Routers</span>
                </a>
                
                <a href="{{ route('admin.payments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 {{ request()->routeIs('admin.payments.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-credit-card w-5"></i>
                    <span class="font-medium">Payments</span>
                </a>
                
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600">
                    <i class="fas fa-history w-5"></i>
                    <span class="font-medium">Admin Logs</span>
                </a>

                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600">
                    <i class="fa-solid fa-gear w-5"></i>
                    <span class="font-medium">Settings</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 ml-64">
        <!-- Top Navigation Bar -->
        <nav class="bg-blue-800 shadow-lg fixed top-0 right-0 left-64 z-50">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <button class="text-white md:hidden mr-4">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i class="fas fa-bell text-white text-xl cursor-pointer hover:text-orange-500 transition"></i>
                            <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-orange-400 to-orange-700 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>  
                            <div class="hidden md:block">
                                <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-200">Administrator</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="hidden md:inline">Logout</span>
                            </button>   
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="mt-20 py-8 px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-800 rounded-2xl p-8 mb-8 text-white">
                <div class="flex justify-between items-center">
                    <div>   
                        <h2 class="text-3xl font-bold mb-2">Customer Management</h2>
                        <p class="text-white">Manage all internet service customers</p>
                    </div>
                    <a href="{{ route('admin.customers.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Add New Customer</span>
                    </a>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Customers Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-orange-50">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-users text-orange-500 mr-2"></i>Customer List
                            <span class="text-sm font-normal text-gray-500 ml-2">({{ $customers->total() }} total)</span>
                        </h3>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search by name, phone, or customer #..." 
                                       class="w-64 px-4 py-2 pl-10 border rounded-lg focus:outline-none focus:border-orange-500 text-sm">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                            </div>
                            <button onclick="clearSearch()" id="clearSearchBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition hidden">
                                <i class="fas fa-times"></i>
                            </button>
                            <button onclick="filterCustomers()" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition">
                                <i class="fas fa-search mr-1"></i>Search
                            </button>
                        </div>
                    </div>
                    <!-- Filter chips -->
                    <div class="flex flex-wrap gap-2 mt-3" id="filterChips">
                        <button onclick="filterByStatus('all')" class="filter-chip px-3 py-1 text-xs rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">All</button>
                        <button onclick="filterByStatus('active')" class="filter-chip px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 hover:bg-green-200 transition">Active</button>
                        <button onclick="filterByStatus('inactive')" class="filter-chip px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition">Inactive</button>
                        <button onclick="filterByStatus('synced')" class="filter-chip px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 transition">Synced</button>
                        <button onclick="filterByStatus('unsynced')" class="filter-chip px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition">Unsynced</button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="customersTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" onclick="sortTable(0)">Customer # <i class="fas fa-sort"></i></th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" onclick="sortTable(1)">Name <i class="fas fa-sort"></i></th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Router</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="customersTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse($customers as $customer)
                            <tr class="hover:bg-gray-50 transition customer-row" 
                                data-name="{{ strtolower($customer->name) }}"
                                data-phone="{{ strtolower($customer->phone) }}"
                                data-number="{{ strtolower($customer->customer_number) }}"
                                data-status="{{ $customer->is_active ? 'active' : 'inactive' }}"
                                data-sync="{{ $customer->status }}">
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
                                    <span class="font-medium text-gray-900">{{ $customer->plan_name }}</span><br>
                                    <small class="text-gray-500">₱{{ number_format($customer->plan_price, 2) }}</small>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->router->name ?? 'Not Assigned' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($customer->is_active)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Active
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Inactive
                                        </span>
                                    @endif
                                    <br>
                                    @if($customer->status === 'synced')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 mt-1">
                                            <i class="fas fa-check-double mr-1"></i>Synced
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 mt-1">
                                            <i class="fas fa-sync-alt mr-1"></i>Unsynced
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900 transition" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.customers.edit', $customer) }}" class="text-green-600 hover:text-green-900 transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-users fa-3x mb-2"></i>
                                    <p>No customers found. Click "Add New Customer" to get started.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($customers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    let currentFilter = 'all';
    let currentSearchTerm = '';
    
    function filterCustomers() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        currentSearchTerm = searchTerm;
        const rows = document.querySelectorAll('#customersTableBody tr');
        let visibleCount = 0;
        
        // Show/hide clear button
        const clearBtn = document.getElementById('clearSearchBtn');
        if (searchTerm.length > 0) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
        
        rows.forEach(row => {
            if (row.querySelector('td')) {
                const name = row.getAttribute('data-name') || '';
                const phone = row.getAttribute('data-phone') || '';
                const customerNumber = row.getAttribute('data-number') || '';
                const rowStatus = row.getAttribute('data-status') || '';
                const rowSync = row.getAttribute('data-sync') || '';
                
                // Check search match
                let searchMatch = true;
                if (searchTerm) {
                    searchMatch = name.includes(searchTerm) || 
                                 phone.includes(searchTerm) || 
                                 customerNumber.includes(searchTerm);
                }
                
                // Check filter match
                let filterMatch = true;
                if (currentFilter === 'active') {
                    filterMatch = rowStatus === 'active';
                } else if (currentFilter === 'inactive') {
                    filterMatch = rowStatus === 'inactive';
                } else if (currentFilter === 'synced') {
                    filterMatch = rowSync === 'synced';
                } else if (currentFilter === 'unsynced') {
                    filterMatch = rowSync === 'unsynced';
                }
                
                if (searchMatch && filterMatch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            }
        });
        
        // Show no results message
        const tbody = document.getElementById('customersTableBody');
        const noResultsRow = document.getElementById('noResultsRow');
        
        if (visibleCount === 0 && rows.length > 0) {
            if (!noResultsRow) {
                const tr = document.createElement('tr');
                tr.id = 'noResultsRow';
                tr.innerHTML = `<td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-search fa-3x mb-2"></i>
                                    <p>No customers match your search criteria.</p>
                                    <button onclick="clearSearch()" class="mt-2 text-orange-500 hover:text-orange-600">Clear search</button>
                                </td>`;
                tbody.appendChild(tr);
            }
        } else {
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }
    }
    
    function filterByStatus(status) {
        currentFilter = status;
        
        // Update active chip styling
        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.classList.remove('bg-orange-500', 'text-white');
            chip.classList.add('bg-gray-200', 'text-gray-700');
        });
        
        let activeChip;
        if (status === 'all') activeChip = document.querySelector('.filter-chip:first-child');
        else if (status === 'active') activeChip = document.querySelectorAll('.filter-chip')[1];
        else if (status === 'inactive') activeChip = document.querySelectorAll('.filter-chip')[2];
        else if (status === 'synced') activeChip = document.querySelectorAll('.filter-chip')[3];
        else if (status === 'unsynced') activeChip = document.querySelectorAll('.filter-chip')[4];
        
        if (activeChip) {
            activeChip.classList.remove('bg-gray-200', 'text-gray-700');
            activeChip.classList.add('bg-orange-500', 'text-white');
        }
        
        filterCustomers();
    }
    
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        currentSearchTerm = '';
        filterCustomers();
    }
    
    function sortTable(columnIndex) {
        const table = document.getElementById('customersTable');
        const tbody = document.getElementById('customersTableBody');
        const rows = Array.from(tbody.querySelectorAll('tr:not(#noResultsRow)'));
        
        let isAscending = table.getAttribute('data-sort-asc') === 'true';
        
        rows.sort((a, b) => {
            let aValue = '';
            let bValue = '';
            
            if (columnIndex === 0) {
                aValue = a.querySelector('td:first-child')?.innerText || '';
                bValue = b.querySelector('td:first-child')?.innerText || '';
            } else if (columnIndex === 1) {
                aValue = a.querySelector('td:nth-child(2) span:last-child')?.innerText || '';
                bValue = b.querySelector('td:nth-child(2) span:last-child')?.innerText || '';
            }
            
            if (isAscending) {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });
        
        table.setAttribute('data-sort-asc', !isAscending);
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
        
        // Update sort icons
        const headers = document.querySelectorAll('th');
        headers.forEach(header => {
            const icon = header.querySelector('i');
            if (icon) icon.className = 'fas fa-sort';
        });
        
        const currentHeader = document.querySelectorAll('th')[columnIndex];
        const currentIcon = currentHeader.querySelector('i');
        if (currentIcon) {
            currentIcon.className = isAscending ? 'fas fa-sort-up' : 'fas fa-sort-down';
        }
    }
    
    // Live search as you type
    document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
        filterCustomers();
    });
    
    document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            filterCustomers();
        }
    });
</script>

<style>
    .filter-chip {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .filter-chip:hover {
        transform: translateY(-1px);
    }
    th {
        user-select: none;
    }
    th i {
        margin-left: 5px;
        font-size: 10px;
        opacity: 0.5;
    }
    th:hover i {
        opacity: 1;
    }
</style>
@endsection
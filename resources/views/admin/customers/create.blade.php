@extends('layouts.app')

@section('title', 'Add New Customer')

@section('content')
<div class="min-h-screen flex">
    @include('layouts.sidebar')

    <div class="flex-1 ml-64">
        <!-- Top Navigation Bar (inline version) -->
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
                                <span class="text-white font-bold text-lg">{{ substr(auth()->user()->name ?? 'User', 0, 1) }}</span>
                            </div>  
                            <div class="hidden md:block">
                                <p class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'User' }}</p>
                                <p class="text-xs text-gray-200">
                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        Administrator
                                    @elseif(auth()->user() && auth()->user()->role === 'cashier')
                                        Cashier
                                    @elseif(auth()->user() && auth()->user()->role === 'technician')
                                        Technician
                                    @else
                                        User
                                    @endif
                                </p>
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
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-user-plus text-orange-500 mr-2"></i>Add New Customer
                    </h2>
                    <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>

                <form action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="Enter customer's full name">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address (Optional)</label>
                            <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="customer@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="text" name="phone" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="Enter phone number">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <textarea name="address" required rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="Enter complete address"></textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Plan Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Plan *</label>
                            <select name="plan_name" id="plan_select" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="">Choose a plan</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->name }}" data-price="{{ $plan->price }}">
                                        {{ $plan->name }} - ₱{{ number_format($plan->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('plan_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Plan Price (Auto-filled) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Plan Price</label>
                            <input type="number" name="plan_price" id="plan_price" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" step="0.01">
                            @error('plan_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Router Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Router</label>
                            <select name="router_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="">Select Router (Optional)</option>
                                @foreach($routers as $router)
                                    <option value="{{ $router->id }}">{{ $router->name }} ({{ $router->ip_address }})</option>
                                @endforeach
                            </select>
                            @error('router_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Device Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Device Type</label>
                            <select name="device" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="none">None</option>
                                <option value="V-SOL">V-SOL</option>
                                <option value="Huawei">Huawei</option>
                                <option value="Assorted">Assorted</option>
                            </select>
                            @error('device') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                            <input type="date" name="expiry_date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" value="{{ date('Y-m-d', strtotime('+1 month')) }}">
                            @error('expiry_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Sync Option -->
                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="sync_now" value="1" class="rounded border-gray-300 text-orange-500 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Sync with MikroTik immediately after creation</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Reset</button>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition">
                            <i class="fas fa-save mr-2"></i>Create Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('plan_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        document.getElementById('plan_price').value = price;
    });
</script>
@endsection
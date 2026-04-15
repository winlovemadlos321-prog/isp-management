@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="min-h-screen flex">
    @include('layouts.sidebar')

    <div class="flex-1 ml-64">
        @include('layouts.topbar')

        <div class="mt-20 py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-user-edit text-orange-500 mr-2"></i>Edit Customer: {{ $customer->name }}
                    </h2>
                    <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>

                <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Number (Read Only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Customer Number</label>
                            <input type="text" value="{{ $customer->customer_number }}" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" required value="{{ old('name', $customer->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address (Optional)</label>
                            <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="customer@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="text" name="phone" required value="{{ old('phone', $customer->phone) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <textarea name="address" required rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">{{ old('address', $customer->address) }}</textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Plan Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Plan *</label>
                            <select name="plan_name" id="plan_select" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="">Choose a plan</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->name }}" data-price="{{ $plan->price }}" {{ old('plan_name', $customer->plan_name) == $plan->name ? 'selected' : '' }}>
                                        {{ $plan->name }} - ₱{{ number_format($plan->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('plan_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Plan Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Plan Price</label>
                            <input type="number" name="plan_price" id="plan_price" readonly value="{{ old('plan_price', $customer->plan_price) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" step="0.01">
                            @error('plan_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Router Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Router</label>
                            <select name="router_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="">Select Router (Optional)</option>
                                @foreach($routers as $router)
                                    <option value="{{ $router->id }}" {{ old('router_id', $customer->router_id) == $router->id ? 'selected' : '' }}>
                                        {{ $router->name }} ({{ $router->ip_address }})
                                    </option>
                                @endforeach
                            </select>
                            @error('router_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Device Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Device Type</label>
                            <select name="device" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="none" {{ old('device', $customer->device) == 'none' ? 'selected' : '' }}>None</option>
                                <option value="V-SOL" {{ old('device', $customer->device) == 'V-SOL' ? 'selected' : '' }}>V-SOL</option>
                                <option value="Huawei" {{ old('device', $customer->device) == 'Huawei' ? 'selected' : '' }}>Huawei</option>
                                <option value="Assorted" {{ old('device', $customer->device) == 'Assorted' ? 'selected' : '' }}>Assorted</option>
                            </select>
                            @error('device') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                            <input type="date" name="expiry_date" required value="{{ old('expiry_date', $customer->expiry_date) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            @error('expiry_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="1" {{ old('is_active', $customer->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $customer->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Reset</button>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition">
                            <i class="fas fa-save mr-2"></i>Update Customer
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
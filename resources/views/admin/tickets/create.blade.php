@extends('layouts.app')

@section('title', 'Create Ticket')

@section('content')
<div class="min-h-screen flex">
    @include('layouts.sidebar')

    <div class="flex-1 ml-64">
        @include('layouts.topbar')

        <div class="mt-10 py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-ticket-alt text-orange-500 mr-2"></i>Create Dispatch Ticket
                    </h2>
                    <a href="{{ route('admin.tickets.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>

                @if($customers->isEmpty())
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
                        <p><i class="fas fa-exclamation-triangle mr-2"></i> No customers found.</p>
                        <a href="{{ route('admin.customers.create') }}" class="text-yellow-800 underline">Click here to add a customer first</a>
                    </div>
                @endif

                <form action="{{ route('admin.tickets.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Select Customer -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Customer *</label>
                            <select name="customer_id" id="customer_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" 
                                        data-name="{{ $customer->name }}" 
                                        data-phone="{{ $customer->phone }}" 
                                        data-address="{{ $customer->address }}" 
                                        data-plan="{{ $customer->plan_name }}" 
                                        data-device="{{ $customer->device }}">
                                        {{ $customer->customer_number }} - {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Customer Details Display -->
                        <div class="md:col-span-2 bg-gray-50 rounded-lg p-4 hidden" id="customerDetails">
                            <h3 class="font-semibold text-gray-800 mb-2">Customer Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <div><span class="text-gray-500">Name:</span> <span id="displayName" class="font-medium"></span></div>
                                <div><span class="text-gray-500">Phone:</span> <span id="displayPhone"></span></div>
                                <div class="md:col-span-2"><span class="text-gray-500">Address:</span> <span id="displayAddress"></span></div>
                                <div><span class="text-gray-500">Plan:</span> <span id="displayPlan"></span></div>
                                <div><span class="text-gray-500">Device:</span> <span id="displayDevice"></span></div>
                            </div>
                        </div>

                        <!-- Poll Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Poll Number</label>
                            <input type="text" name="poll_number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="Enter poll number">
                        </div>

                        <!-- NAP Box Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NAP Box Number</label>
                            <input type="text" name="nap_box_number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="Enter NAP box number">
                        </div>

                        <!-- Priority -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                            <select name="priority" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="low">Low</option>
                                <option value="normal" selected>Normal</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>

                        <!-- Assign to Technician - Fixed with specific names -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Technician</label>
                            <select name="assigned_to" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}">
                                        {{ $tech->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Scheduled Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date</label>
                            <input type="date" name="scheduled_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                        </div>

                        <!-- Scheduled Time -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled Time</label>
                            <input type="time" name="scheduled_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="Describe the issue or installation details..."></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Reset</button>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 transition">
                            <i class="fas fa-save mr-2"></i>Create Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('customer_id').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const detailsDiv = document.getElementById('customerDetails');
        
        if (this.value) {
            detailsDiv.classList.remove('hidden');
            document.getElementById('displayName').textContent = selected.dataset.name || '';
            document.getElementById('displayPhone').textContent = selected.dataset.phone || '';
            document.getElementById('displayAddress').textContent = selected.dataset.address || '';
            document.getElementById('displayPlan').textContent = selected.dataset.plan || '';
            document.getElementById('displayDevice').textContent = selected.dataset.device || 'None';
        } else {
            detailsDiv.classList.add('hidden');
        }
    });
</script>
@endsection
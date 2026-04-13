@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="min-h-screen flex">


    <div class="flex-1 ml-64">
     

        <div class="mt-20 py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-user-circle text-orange-500 mr-2"></i>Customer Details
                    </h2>
                    <div class="space-x-2">
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Customer Number</label>
                        <p class="text-lg font-semibold text-orange-600">{{ $customer->customer_number }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Full Name</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $customer->name }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Phone Number</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $customer->phone }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Address</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $customer->address }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Plan</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $customer->plan_name }}</p>
                        <small class="text-gray-500">₱{{ number_format($customer->plan_price, 2) }}/month</small>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Router</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $customer->router->name ?? 'Not Assigned' }}</p>
                        @if($customer->router)
                            <small class="text-gray-500">{{ $customer->router->ip_address }}</small>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Device Type</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $customer->device }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Expiry Date</label>
                        <p class="text-lg font-semibold text-gray-800">{{ date('F d, Y', strtotime($customer->expiry_date)) }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        @if($customer->is_active)
                            <p class="text-lg font-semibold text-green-600">Active</p>
                        @else
                            <p class="text-lg font-semibold text-red-600">Inactive</p>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Sync Status</label>
                        @if($customer->status === 'synced')
                            <p class="text-lg font-semibold text-green-600">Synced with MikroTik</p>
                        @else
                            <p class="text-lg font-semibold text-yellow-600">Not Synced</p>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Created At</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $customer->created_at->format('F d, Y h:i A') }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-sm font-medium text-gray-500">Last Updated</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $customer->updated_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
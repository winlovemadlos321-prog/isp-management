@extends('layouts.app')

@section('title', 'Ticket Details')

@section('content')
<div class="min-h-screen flex">
    @include('layouts.sidebar')

    <div class="flex-1 ml-64">
        @include('layouts.topbar')

        <div class="mt-10 py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-ticket-alt text-orange-500 mr-2"></i>Ticket Details
                    </h2>
                    <div>
                        <a href="{{ route('admin.tickets.edit', $ticket) }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition mr-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.tickets.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Ticket Number</label>
                        <p class="text-lg font-bold text-orange-600">{{ $ticket->ticket_number }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Status</label>
                        <p>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'assigned' => 'bg-blue-100 text-blue-800',
                                    'in_progress' => 'bg-purple-100 text-purple-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$ticket->status] }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Customer Name</label>
                        <p class="text-gray-800">{{ $ticket->customer_name }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Phone Number</label>
                        <p class="text-gray-800">{{ $ticket->customer_phone }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                        <label class="text-xs text-gray-500">Address</label>
                        <p class="text-gray-800">{{ $ticket->customer_address }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Plan</label>
                        <p class="text-gray-800">{{ $ticket->plan_name }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Device Type</label>
                        <p class="text-gray-800">{{ $ticket->device_type ?? 'Not specified' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Poll Number</label>
                        <p class="text-gray-800">{{ $ticket->poll_number ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">NAP Box Number</label>
                        <p class="text-gray-800">{{ $ticket->nap_box_number ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Priority</label>
                        @php
                            $priorityColors = [
                                'low' => 'text-gray-600',
                                'normal' => 'text-blue-600',
                                'high' => 'text-orange-600',
                                'urgent' => 'text-red-600'
                            ];
                        @endphp
                        <p class="font-semibold uppercase {{ $priorityColors[$ticket->priority] }}">{{ $ticket->priority }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Assigned To</label>
                        <p class="text-gray-800">{{ $ticket->technician->name ?? 'Unassigned' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Scheduled Date</label>
                        <p class="text-gray-800">{{ $ticket->scheduled_date ? \Carbon\Carbon::parse($ticket->scheduled_date)->format('M d, Y') : 'Not scheduled' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Scheduled Time</label>
                        <p class="text-gray-800">{{ $ticket->scheduled_time ? \Carbon\Carbon::parse($ticket->scheduled_time)->format('h:i A') : 'Not scheduled' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500">Created At</label>
                        <p class="text-gray-800">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                        <label class="text-xs text-gray-500">Description</label>
                        <p class="text-gray-800">{{ $ticket->description ?? 'No description' }}</p>
                    </div>
                    @if($ticket->technician_notes)
                    <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                        <label class="text-xs text-gray-500">Technician Notes</label>
                        <p class="text-gray-800">{{ $ticket->technician_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
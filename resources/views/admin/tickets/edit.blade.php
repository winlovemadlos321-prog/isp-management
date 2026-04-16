@extends('layouts.app')

@section('title', 'Edit Ticket')

@section('content')
<div class="min-h-screen flex">
    @include('layouts.sidebar')

    <div class="flex-1 ml-64">
        @include('layouts.topbar')

        <div class="mt-10 py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-edit text-orange-500 mr-2"></i>Edit Ticket: {{ $ticket->ticket_number }}
                    </h2>
                    <a href="{{ route('admin.tickets.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>

                <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <label class="text-xs text-gray-500">Ticket Number</label>
                            <p class="font-bold text-orange-600">{{ $ticket->ticket_number }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <label class="text-xs text-gray-500">Customer</label>
                            <p class="font-medium">{{ $ticket->customer_name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Poll Number</label>
                            <input type="text" name="poll_number" value="{{ $ticket->poll_number }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NAP Box Number</label>
                            <input type="text" name="nap_box_number" value="{{ $ticket->nap_box_number }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="assigned" {{ $ticket->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $ticket->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $ticket->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                            <select name="priority" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="normal" {{ $ticket->priority == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign to Technician</label>
                            <select name="assigned_to" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                                <option value="">-- Select Technician --</option>
                                <option value="winlove" {{ $ticket->assigned_to == 'winlove' ? 'selected' : '' }}>Winlove</option>
                                <option value="rj" {{ $ticket->assigned_to == 'rj' ? 'selected' : '' }}>RJ</option>
                                <option value="aleck" {{ $ticket->assigned_to == 'aleck' ? 'selected' : '' }}>Aleck</option>
                                <option value="manong" {{ $ticket->assigned_to == 'manong' ? 'selected' : '' }}>Manong</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date</label>
                            <input type="date" name="scheduled_date" value="{{ $ticket->scheduled_date ? \Carbon\Carbon::parse($ticket->scheduled_date)->format('Y-m-d') : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled Time</label>
                            <input type="time" name="scheduled_time" value="{{ $ticket->scheduled_time ? \Carbon\Carbon::parse($ticket->scheduled_time)->format('H:i') : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">{{ $ticket->description }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Technician Notes</label>
                            <textarea name="technician_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">{{ $ticket->technician_notes }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 transition">
                            <i class="fas fa-save mr-2"></i>Update Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
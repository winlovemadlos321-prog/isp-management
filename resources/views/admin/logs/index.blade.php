@extends('layouts.app')

@section('title', 'Admin Logs')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('layouts.sidebar')
    
    <!-- Main Content Area -->
    <div class="flex-1 ml-64">

        @include('layouts.topbar')

        <!-- Main Content -->
        <div class="mt-20 py-8 px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Admin Logs</h1>
                <p class="text-gray-500 text-sm mt-1">Track and monitor all administrative activities across the system</p>
            </div>

            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Events</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_events'] ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <i class="fas fa-chart-line text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> +12.5% from last month</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Successful Logins</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['successful_logins'] ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="fas fa-sign-in-alt text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> +8.3% from last month</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Failed Attempts</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['failed_attempts'] ?? 0 }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-red-600 mt-2"><i class="fas fa-arrow-down"></i> -5.2% from last month</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Active Sessions</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['active_sessions'] ?? 0 }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <i class="fas fa-users text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">Currently logged in admins</p>
                </div>
            </div>

            <!-- Filter and Search Bar -->
            <div class="bg-white rounded-lg shadow mb-6 p-4">
                <form method="GET" action="{{ route('admin.logs.index') }}" id="filterForm">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Search Input -->
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" placeholder="Search logs by user, action, or IP address..." 
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <!-- Date Range Filter -->
                        <div class="flex gap-2">
                            <div class="relative">
                                <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="relative">
                                <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <!-- Action Filter -->
                        <div class="relative">
                            <i class="fas fa-filter absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="action_type" class="pl-10 pr-8 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                                <option value="">All Actions</option>
                                <option value="login" {{ request('action_type') == 'login' ? 'selected' : '' }}>Login</option>
                                <option value="logout" {{ request('action_type') == 'logout' ? 'selected' : '' }}>Logout</option>
                                <option value="create" {{ request('action_type') == 'create' ? 'selected' : '' }}>Create</option>
                                <option value="update" {{ request('action_type') == 'update' ? 'selected' : '' }}>Update</option>
                                <option value="delete" {{ request('action_type') == 'delete' ? 'selected' : '' }}>Delete</option>
                                <option value="config" {{ request('action_type') == 'config' ? 'selected' : '' }}>Configuration</option>
                                <option value="permission" {{ request('action_type') == 'permission' ? 'selected' : '' }}>Permission</option>
                                <option value="network" {{ request('action_type') == 'network' ? 'selected' : '' }}>Network</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        <!-- Status Filter -->
                        <div class="relative">
                            <i class="fas fa-flag-checkered absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="status" class="pl-10 pr-8 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
                                <option value="">All Status</option>
                                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="warning" {{ request('status') == 'warning' ? 'selected' : '' }}>Warning</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        <!-- Export Button -->
                        <a 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                            <i class="fas fa-download"></i>
                            <span>Export</span>
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            <span>Filter</span>
                        </button>
                        @if(request()->anyFilled(['search', 'start_date', 'end_date', 'action_type', 'status']))
                            <a href="{{ route('admin.logs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                                <i class="fas fa-times"></i>
                                <span>Clear</span>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Logs Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" class="rounded border-gray-300" id="selectAll">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="rounded border-gray-300 log-checkbox" value="{{ $log->id }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold text-sm">{{ substr($log->admin_name ?? 'S', 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $log->admin_name ?? 'System' }}</p>
                                            <p class="text-xs text-gray-500">{{ $log->admin_role ?? 'System' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $actionColors = [
                                            'login' => 'bg-green-100 text-green-800',
                                            'logout' => 'bg-gray-100 text-gray-800',
                                            'create' => 'bg-blue-100 text-blue-800',
                                            'update' => 'bg-yellow-100 text-yellow-800',
                                            'delete' => 'bg-red-100 text-red-800',
                                            'config' => 'bg-purple-100 text-purple-800',
                                            'permission' => 'bg-indigo-100 text-indigo-800',
                                            'network' => 'bg-orange-100 text-orange-800',
                                        ];
                                        $actionIcons = [
                                            'login' => 'sign-in-alt',
                                            'logout' => 'sign-out-alt',
                                            'create' => 'plus',
                                            'update' => 'edit',
                                            'delete' => 'trash',
                                            'config' => 'cog',
                                            'permission' => 'user-shield',
                                            'network' => 'wifi',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full {{ $actionColors[$log->action_type] ?? 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-{{ $actionIcons[$log->action_type] ?? 'circle' }} mr-1"></i> 
                                        {{ ucfirst($log->action_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($log->description, 60) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->ip_address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'success' => 'bg-green-100 text-green-800',
                                            'failed' => 'bg-red-100 text-red-800',
                                            'warning' => 'bg-yellow-100 text-yellow-800',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$log->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button class="text-blue-600 hover:text-blue-800 mr-2 view-log" data-id="{{ $log->id }}" data-description="{{ $log->description }}" data-details='{{ json_encode($log->details) }}' title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800 delete-log" data-id="{{ $log->id }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-database text-4xl mb-2 block"></i>
                                    No logs found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} results
                    </div>
                    <div>
                        {{ $logs->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

            <!-- Real-time Activity Feed -->
            <div class="mt-6">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-clock text-blue-600 mr-2"></i>
                            Recent Activity
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            @forelse($recentActivity ?? [] as $activity)
                            <div class="flex items-start space-x-3 p-2 hover:bg-gray-50 rounded-lg transition">
                                @php
                                    $activityColors = [
                                        'login' => 'green',
                                        'create' => 'blue',
                                        'update' => 'orange',
                                        'delete' => 'red',
                                        'failed' => 'red',
                                    ];
                                    $color = $activityColors[$activity->action_type] ?? ($activity->status == 'failed' ? 'red' : 'gray');
                                @endphp
                                <div class="w-2 h-2 bg-{{ $color }}-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-800">
                                        <span class="font-semibold">{{ $activity->admin_name ?? 'System' }}</span> 
                                        {{ $activity->description }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                                @if($activity->status == 'success')
                                    <i class="fas fa-check-circle text-green-500"></i>
                                @elseif($activity->status == 'failed')
                                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                                @else
                                    <i class="fas fa-info-circle text-blue-500"></i>
                                @endif
                            </div>
                            @empty
                            <div class="text-center text-gray-500 py-4">
                                No recent activity
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Log Details -->
<div id="logModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Log Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mb-4">
            <p class="text-sm text-gray-600" id="logDescription"></p>
        </div>
        <div id="logDetails" class="mb-4">
            <!-- Additional details will be inserted here -->
        </div>
        <div class="flex justify-end">
            <button onclick="closeModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
// Select All Checkbox
document.getElementById('selectAll')?.addEventListener('change', function(e) {
    document.querySelectorAll('.log-checkbox').forEach(checkbox => {
        checkbox.checked = e.target.checked;
    });
});

// View Log Details
document.querySelectorAll('.view-log').forEach(button => {
    button.addEventListener('click', function() {
        const description = this.dataset.description;
        const details = JSON.parse(this.dataset.details || '{}');
        
        document.getElementById('logDescription').textContent = description;
        
        const detailsHtml = document.getElementById('logDetails');
        if (Object.keys(details).length > 0) {
            detailsHtml.innerHTML = '<h4 class="font-semibold text-sm mb-2">Additional Details:</h4><pre class="text-xs bg-gray-50 p-2 rounded">' + JSON.stringify(details, null, 2) + '</pre>';
        } else {
            detailsHtml.innerHTML = '';
        }
        
        document.getElementById('logModal').classList.remove('hidden');
    });
});

// Delete Log
document.querySelectorAll('.delete-log').forEach(button => {
    button.addEventListener('click', async function() {
        const logId = this.dataset.id;
        if (confirm('Are you sure you want to delete this log entry?')) {
            try {
                const response = await fetch(`/admin/logs/${logId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to delete log entry');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the log');
            }
        }
    });
});

// Close Modal
function closeModal() {
    document.getElementById('logModal').classList.add('hidden');
}

// Auto-submit filter form on select change
document.querySelectorAll('select[name="action_type"], select[name="status"]').forEach(select => {
    select.addEventListener('change', () => {
        document.getElementById('filterForm').submit();
    });
});

// Auto-submit on date change
document.querySelectorAll('input[name="start_date"], input[name="end_date"]').forEach(input => {
    input.addEventListener('change', () => {
        if (input.value) {
            document.getElementById('filterForm').submit();
        }
    });
});
</script>

<!-- Additional Styles -->
<style>
    /* Custom scrollbar for the logs table */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Smooth transitions */
    .transition {
        transition: all 0.2s ease-in-out;
    }
    
    /* Hover effect for table rows */
    tbody tr:hover {
        background-color: #f9fafb;
    }
    
    /* Focus ring for inputs */
    input:focus, select:focus {
        outline: none;
        ring: 2px solid #3b82f6;
    }
    
    /* Pagination styling */
    .pagination {
        display: flex;
        gap: 0.5rem;
    }
    .pagination a, .pagination span {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        color: #4a5568;
        text-decoration: none;
    }
    .pagination a:hover {
        background-color: #f7fafc;
    }
    .pagination .active span {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
</style>
@endsection
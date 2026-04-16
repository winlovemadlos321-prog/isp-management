@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 ml-64">
        <!-- Top Navigation Bar -->
        @include('layouts.topbar')

        <!-- Main Content -->
        <div class="mt-10 py-8 px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-800 rounded-2xl p-8 mb-8 text-white">
                <div class="flex justify-between items-center">
                    <div>   
                        <h2 class="text-3xl font-bold mb-2">User Management</h2>
                        <p class="text-white">Manage system users, roles, and permissions</p>
                    </div>
                    <a href="{{ route('admin.users.create') }}" 
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Add New User</span>
                    </a>
                </div>
            </div>

            <!-- Toast Container -->
            <div id="toastContainer" class="fixed top-24 right-4 z-50 space-y-2"></div>

            <!-- Users Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-orange-50">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-users text-orange-500 mr-2"></i>System Users
                        </h3>
                        <!-- Search Form - Server Side -->
                        <form method="GET" action="{{ route('admin.users.index') }}" class="flex space-x-2">
                            <input type="text" name="search" placeholder="Search users..." 
                                   value="{{ request('search') }}"
                                   class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg transition">
                                    Clear
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition" id="user-row-{{ $user->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white font-bold text-sm">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {!! $user->role_badge !!}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900 mr-3 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" class="text-red-600 hover:text-red-900 transition">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    @else
                                        <button class="text-gray-500 cursor-not-allowed" title="Cannot delete your own account">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-users fa-3x mb-2 block"></i>
                                    <p>No users found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-4 py-2">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="mb-4 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete User</h3>
            <p class="text-gray-500">Are you sure you want to delete <span id="deleteUserName" class="font-bold text-gray-700"></span>?</p>
            <p class="text-sm text-red-500 mt-2">This action cannot be undone!</p>
        </div>
        
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center space-x-3">
                <button type="button" onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Delete User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toast notification system
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `transform transition-all duration-500 ease-in-out translate-x-0 opacity-100 mb-3`;
        toast.innerHTML = `
            <div class="bg-white rounded-lg shadow-lg border-l-4 ${type === 'success' ? 'border-green-500' : 'border-red-500'} p-4 min-w-[300px]">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        ${type === 'success' ? '<i class="fas fa-check-circle text-green-500 text-xl"></i>' : '<i class="fas fa-exclamation-circle text-red-500 text-xl"></i>'}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-800">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="ml-auto text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        toastContainer.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }

    // Flash messages
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif

    // Delete confirmation
    function confirmDelete(userId, userName) {
        document.getElementById('deleteUserName').innerText = userName;
        document.getElementById('deleteForm').action = `/admin/users/${userId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const deleteModal = document.getElementById('deleteModal');
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }
</script>
@endsection
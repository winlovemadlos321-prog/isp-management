@extends('layouts.app')

@section('title', 'Manage Users')

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
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200">
                    <i class="fas fa-home w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-gradient-to-r from-orange-500 to-orange-600 transition-all duration-200">
                    <i class="fas fa-user-shield w-5"></i>
                    <span class="font-medium">Users</span>
                </a>
                
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600">
                    <i class="fas fa-tags w-5"></i>
                    <span class="font-medium">Plans</span>
                </a>
                
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600">
                    <i class="fas fa-users w-5"></i>
                    <span class="font-medium">Customers</span>
                </a>
                
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600">
                    <i class="fas fa-credit-card w-5"></i>
                    <span class="font-medium">Payments</span>
                </a>
                
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600">
                    <i class="fas fa-history w-5"></i>
                    <span class="font-medium">Admin Logs</span>
                </a>

                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:text-white transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600">
                    <i class="fa-solid fa-gear"></i>
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
                        <h2 class="text-3xl font-bold mb-2">User Management</h2>
                        <p class="text-white">Manage system users, roles, and permissions</p>
                    </div>
                    <button onclick="openCreateModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Add New User</span>
                    </button>
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

            <!-- Users Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-orange-50">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-users text-orange-500 mr-2"></i>System Users
                        </h3>
                        <div class="flex space-x-2">
                            <input type="text" id="searchInput" placeholder="Search users..." class="px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                            <button onclick="filterUsers()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
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
                            @foreach($users as $user)
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
                                    @if($user->role === 'admin')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <i class="fas fa-crown mr-1"></i>Admin
                                        </span>
                                    @elseif($user->role === 'staff')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <i class="fas fa-user-tie mr-1"></i>Staff
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <i class="fas fa-user mr-1"></i>User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="openEditModal({{ $user->id }})" class="text-blue-600 hover:text-blue-900 mr-3 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" class="text-red-600 hover:text-red-900 transition">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed" title="Cannot delete your own account">
                                            <i class="fas fa-trash"></i> Delete
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($users->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-users fa-3x mb-2"></i>
                        <p>No users found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit User Modal -->
<div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Add New User</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="userForm" method="POST">
            @csrf
            <input type="hidden" id="userMethod" name="_method" value="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" required 
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-red-500 text-xs italic hidden" id="nameError"></p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" required 
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-red-500 text-xs italic hidden" id="emailError"></p>
            </div>
            
            <div class="mb-4" id="passwordField">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password" name="password" 
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-gray-500 text-xs mt-1">Minimum 8 characters</p>
                <p class="text-red-500 text-xs italic hidden" id="passwordError"></p>
            </div>
            
            <div class="mb-4" id="passwordConfirmField">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                    Confirm Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                    Role <span class="text-red-500">*</span>
                </label>
                <select id="role" name="role" required 
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="user">User</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal()" 
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Save User
                </button>
            </div>
        </form>
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
    // Search/Filter functionality
    function filterUsers() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#usersTableBody tr');
        
        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            const email = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
            
            if (name.includes(searchTerm) || email.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Open Create Modal
    function openCreateModal() {
        document.getElementById('modalTitle').innerText = 'Add New User';
        document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
        document.getElementById('userMethod').value = 'POST';
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
        document.getElementById('role').value = 'user';
        
        // Show password fields for new user
        document.getElementById('passwordField').style.display = 'block';
        document.getElementById('passwordConfirmField').style.display = 'block';
        document.getElementById('password').required = true;
        
        // Clear any error messages
        clearErrors();
        
        document.getElementById('userModal').classList.remove('hidden');
    }
    
    // Open Edit Modal
    function openEditModal(userId) {
        // Fetch user data via AJAX
        fetch(`/admin/users/${userId}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').innerText = 'Edit User';
                document.getElementById('userForm').action = `/admin/users/${userId}`;
                document.getElementById('userMethod').value = 'PUT';
                document.getElementById('name').value = data.name;
                document.getElementById('email').value = data.email;
                document.getElementById('role').value = data.role;
                
                // Hide password fields for edit (optional password update)
                document.getElementById('passwordField').style.display = 'none';
                document.getElementById('passwordConfirmField').style.display = 'none';
                document.getElementById('password').required = false;
                
                // Clear any error messages
                clearErrors();
                
                document.getElementById('userModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load user data');
            });
    }
    
    // Confirm Delete
    function confirmDelete(userId, userName) {
        document.getElementById('deleteUserName').innerText = userName;
        document.getElementById('deleteForm').action = `/admin/users/${userId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    // Close Modal
    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
        clearErrors();
    }
    
    // Close Delete Modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Clear error messages
    function clearErrors() {
        const errors = ['nameError', 'emailError', 'passwordError'];
        errors.forEach(error => {
            const element = document.getElementById(error);
            if (element) {
                element.classList.add('hidden');
                element.innerText = '';
            }
        });
    }
    
    // Form validation
    document.getElementById('userForm').addEventListener('submit', function(e) {
        let isValid = true;
        const password = document.getElementById('password').value;
        
        // Validate name
        if (!document.getElementById('name').value.trim()) {
            showError('nameError', 'Name is required');
            isValid = false;
        }
        
        // Validate email
        const email = document.getElementById('email').value;
        if (!email) {
            showError('emailError', 'Email is required');
            isValid = false;
        } else if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            showError('emailError', 'Please enter a valid email address');
            isValid = false;
        }
        
        // Validate password only for new users (when password field is visible)
        if (document.getElementById('passwordField').style.display !== 'none' && password) {
            if (password.length < 8) {
                showError('passwordError', 'Password must be at least 8 characters');
                isValid = false;
            }
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
    
    function showError(elementId, message) {
        const element = document.getElementById(elementId);
        element.innerText = message;
        element.classList.remove('hidden');
    }
    
    // Search on Enter key
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            filterUsers();
        }
    });
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('userModal');
        const deleteModal = document.getElementById('deleteModal');
        if (event.target === modal) {
            closeModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }
</script>
@endsection
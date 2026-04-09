    @extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 ml-64">
        <!-- Top Navigation Bar -->
        @include('layouts.topbar')

        <!-- Main Content -->
        <div class="mt-20 py-8 px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-800 rounded-2xl p-8 mb-8 text-white">
                <div class="flex justify-between items-center">
                    <div>   
                        <h2 class="text-3xl font-bold mb-2">Edit User</h2>
                        <p class="text-white">Update user account information</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Users</span>
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mx-60">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-orange-50">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-user-edit text-orange-500 mr-2"></i>Edit User Information
                    </h3>
                </div>
                
                <div class="p-6 mx-5">
                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-bold">Please fix the following errors:</span>
                            </div>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Password (optional) -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                    Password
                                </label>
                                <input type="password" id="password" name="password"
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                                <p class="text-gray-500 text-xs mt-1">Leave blank to keep current password. Minimum 8 characters if changed.</p>
                                @error('password')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Password Confirmation -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                                    Confirm Password
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <!-- Role -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select id="role" name="role" required 
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="" selected disabled>--Select Role--</option>
                                    <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Cashier" {{ old('role', $user->role) == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                                    <option value="Technician" {{ old('role', $user->role) == 'Technician' ? 'selected' : '' }}>Technician</option>
                                    <option value="Marketing" {{ old('role', $user->role) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="Finance" {{ old('role', $user->role) == 'Finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="HR/Accounts" {{ old('role', $user->role) == 'HR/Accounts' ? 'selected' : '' }}>HR/Accounts</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->   
                        <div class="flex justify-end space-x-3 mt-8">
                            <a href="{{ route('admin.users.index') }}" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-save mr-1"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
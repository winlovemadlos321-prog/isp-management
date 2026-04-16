@extends('layouts.app')

@section('title', 'Admin Settings')

@section('content')
<div class="min-h-screen flex">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 ml-64">

        <!-- Topbar -->
        @include('layouts.topbar')

        <div class="mt-10 py-8 px-4 sm:px-6 lg:px-8">

            <!-- Header Banner -->
            <div class="bg-gradient-to-r from-blue-500 via-blue-600 via-10% to-blue-800 rounded-2xl p-8 mb-8 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Account Settings</h2>
                        <p class="text-white/90">Manage your admin profile, security, and system preferences.</p>
                    </div>
                    <div class="hidden md:block">
                        <i class="fas fa-cog text-6xl  text-white/70"></i>
                    </div>
                </div>
            </div>

            <!-- Settings Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Profile Settings -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-user text-orange-500"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Profile Information</h3>
                    </div>
                    
                    {{-- action="{{ route('admin.settings.updateProfile') }}" use this if have blade for updateprofile.  --}} 
                    <form method="POST" action="" class="space-y-4"> 
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="text-sm text-gray-600">Full Name</label>
                            <input type="text" name="name"
                                   value="{{ auth()->user()->name }}"
                                   class="w-full mt-1 shadow border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Email Address</label>
                            <input type="email" name="email"
                                   value="{{ auth()->user()->email }}"
                                   class="w-full mt-1 shadow border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-200">
                        </div>

                        <button class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition">
                            Update Profile
                        </button>
                    </form>
                </div>  

                <!-- Security Settings -->
                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-lock text-orange-500"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Security</h3>
                    </div>

                    {{-- action="{{ route('admin.settings.updatePassword') }}" use this if have blade for updatepassword. --}} 
                    <form method="POST" action="" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="text-sm text-gray-600">Current Password</label>
                            <input type="password" name="current_password"
                                   class="w-full mt-1 shadow border border-gray-300 rounded-xl p-3">
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">New Password</label>
                            <input type="password" name="password"
                                   class="w-full mt-1 shadow border border-gray-300 rounded-xl p-3">
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full mt-1 shadow border border-gray-300 rounded-xl p-3">
                        </div>

                        <button class="w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 transition">
                            Change Password
                        </button>
                    </form>
                </div>

                <!-- System Info -->
                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-server text-orange-500"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">System Info</h3>
                    </div>

                    <div class="space-y-4 text-sm">

                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-gray-500">Role</p>
                            <p class="font-semibold text-gray-800">Administrator</p>
                        </div>

                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-gray-500">Account Status</p>
                            <p class="font-semibold text-green-600">Active</p>
                        </div>

                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-gray-500">Last Login</p>
                            <p class="font-semibold text-gray-800">
                                {{ auth()->user()->last_login_at ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-gray-500">System Version</p>
                            <p class="font-semibold text-gray-800">ISP v1.0</p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
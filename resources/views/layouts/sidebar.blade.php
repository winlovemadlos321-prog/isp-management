{{-- resources/views/layouts/sidebar.blade.php --}}
@php
    $userRole = auth()->user()->role ?? 'guest';
@endphp

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
            @if($userRole === 'admin')
                {{-- Admin Menu Items --}}
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-user-shield w-5"></i>
                    <span class="font-medium">Users</span>
                </a>
                
                <a href="{{ route('admin.plans.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.plans.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span class="font-medium">Plans</span>
                </a>
                
                <a href="{{ route('admin.customers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.customer.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="font-medium">Customers</span>
                </a>
                
                <a href="{{ route('admin.routers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.routers.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-server w-5"></i>
                    <span class="font-medium">Routers</span>
                </a>
                
                <a href="{{ route('admin.payments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('admin.payments.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-credit-card w-5"></i>
                    <span class="font-medium">Payments</span>
                </a>
                
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600 transition-all duration-200">
                    <i class="fas fa-history w-5"></i>
                    <span class="font-medium">Admin Logs</span>
                </a>

                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600 transition-all duration-200">
                    <i class="fa-solid fa-gear w-5"></i>
                    <span class="font-medium">Settings</span>
                </a>

            @elseif($userRole === 'cashier')
                {{-- Cashier Menu Items --}}
                <a href="{{ route('cashier.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('cashier.dashboard') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('cashier.customers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('cashier.customers.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="font-medium">Customers</span>
                </a>
                
                <a href="{{ route('cashier.payments.create') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('cashier.payments.create') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-receipt w-5"></i>
                    <span class="font-medium">Record Payment</span>
                </a>
                
                <a href="{{ route('cashier.payments.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('cashier.payments.index') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-history w-5"></i>
                    <span class="font-medium">Payment History</span>
                </a>

            @elseif($userRole === 'technician')
                {{-- Technician Menu Items --}}
                <a href="{{ route('technician.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('technician.dashboard') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('technician.customers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('technician.customers.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="font-medium">Customers</span>
                </a>
                
                <a href="{{ route('technician.installations.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('technician.installations.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-tools w-5"></i>
                    <span class="font-medium">Installations</span>
                </a>
                
                <a href="{{ route('technician.routers.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('technician.routers.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                    <i class="fas fa-server w-5"></i>
                    <span class="font-medium">Routers</span>
                </a>

            @else
                {{-- Default Menu --}}
                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600">
                    <i class="fas fa-home w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
            @endif

            {{-- Common Bottom Menu Items (visible for all roles) --}}
            <div class="pt-6 mt-6 border-t border-blue-700">
                {{-- Profile link removed temporarily --}}
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 transition-all duration-200 w-full">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</aside>
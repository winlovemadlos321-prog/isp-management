<!-- Sidebar -->
<aside class="w-64 bg-blue-800 shadow-xl fixed h-full z-40 top-0 left-0">
    <div class="p-6 border-b border-blue-700">
        <div class="flex items-left space-x-3">   
            <div class="mx-auto h-12 w-12 rounded-full flex items-center justify-center shadow-lg">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('asset/logo.png') }}" alt="GameTech Logo" class="rounded-full">
                </a>
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
            
            <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:bg-gradient-to-r from-orange-500 to-orange-600 transition-all duration-200">
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
<!-- Top Navigation Bar --> 
<nav class="bg-blue-800 shadow-lg fixed top-0 right-0 left-64 z-50">
    <div class="px-4 sm:px-6 lg:px-8 top-0">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Mobile menu button (hidden on desktop) -->
                <button class="text-white md:hidden mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <!-- User Menu -->
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
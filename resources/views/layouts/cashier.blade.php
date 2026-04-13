<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cashier Panel') - GameTech ISP</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        .sidebar-item {
            transition: all 0.3s ease;
        }
        .sidebar-item:hover {
            transform: translateX(5px);
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Cashier Sidebar -->
        <aside class="w-64 bg-blue-800 shadow-xl fixed h-full z-40 top-0 left-0">
            <div class="p-6 border-b border-blue-700">
                <div class="flex items-left space-x-3">   
                    <div class="mx-auto h-12 w-12 rounded-full flex items-center justify-center shadow-lg">
                        <img src="{{ asset('asset/logo.png') }}" alt="GameTech Logo" class="rounded-full">
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white"> <span class="text-yellow-400 text-lg">G</span>ameTech</h2>
                        <h2 class="text-lg font-bold text-white">UNLI FIBER</h2>
                        <p class="text-xs text-gray-300">Cashier Panel</p>
                    </div>
                </div>  
            </div>
            
            <nav class="mt-6 px-4">
                <div class="space-y-2">
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
                    
                    <a href="{{ route('cashier.payments.history') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('cashier.payments.history') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                        <i class="fas fa-history w-5"></i>
                        <span class="font-medium">Payment History</span>
                    </a>
                    
                    <!-- Daily Report Link - ADDED -->
                    <a href="{{ route('cashier.daily.report') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white transition-all duration-200 {{ request()->routeIs('cashier.daily.report') ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600' }}">
                        <i class="fas fa-chart-line w-5"></i>
                        <span class="font-medium">Daily Report</span>
                    </a>
                </div>
                
                <div class="pt-6 mt-6 border-t border-blue-700">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 transition-all duration-200 w-full">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
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
                            <button class="text-white md:hidden mr-4" onclick="toggleSidebar()">
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
                                    <p class="text-xs text-gray-200">Cashier</p>
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

            <!-- Content -->
            <div class="mt-16">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            const mainContent = document.querySelector('.flex-1');
            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-0', 'overflow-hidden');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-0');
            } else {
                sidebar.classList.remove('w-0', 'overflow-hidden');
                sidebar.classList.add('w-64');
                mainContent.classList.remove('ml-0');
                mainContent.classList.add('ml-64');
            }
        }
    </script>
</body>
</html>
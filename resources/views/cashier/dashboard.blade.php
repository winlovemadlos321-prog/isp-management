@extends('layouts.app')

@section('title', 'Cashier Dashboard')

@section('content')
<div class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cash-register text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">GamTech ISP</h1>
                        <p class="text-xs text-gray-500">Cashier Panel</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Cashier</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl p-8 mb-8 text-white">
            <h2 class="text-3xl font-bold mb-2">Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text-orange-100">Manage payments and customer transactions efficiently.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Today's Collection</p>
                        <p class="text-3xl font-bold text-blue-600">${{ number_format(\App\Models\Payment::whereDate('payment_date', today())->sum('amount'), 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Customers</p>
                        <p class="text-3xl font-bold text-orange-600">{{ \App\Models\Customer::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pending Payments</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\Payment::where('is_reconciled', false)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 text-white">
                <i class="fas fa-plus-circle text-4xl mb-4"></i>
                <h3 class="text-xl font-bold mb-2">New Customer</h3>
                <p class="text-blue-100 mb-4">Register a new customer to the system</p>
                <a href="#" class="inline-flex items-center bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Register Now <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl p-6 text-white">
                <i class="fas fa-receipt text-4xl mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Record Payment</h3>
                <p class="text-orange-100 mb-4">Process customer payment and generate receipt</p>
                <a href="#" class="inline-flex items-center bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Process Payment <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
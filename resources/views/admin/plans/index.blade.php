@extends('layouts.app')

@section('title', 'Manage Plans')

@section('content')
<div class="min-h-screen flex">
    @include('layouts.sidebar')
         @include('layouts.topbar')


    <div class="flex-1 ml-64">

        <div class="mt-20 py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-tags text-orange-500 mr-2"></i>Manage Plans
                    </h2>
                    <a href="{{ route('admin.plans.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-lg hover:from-orange-600 hover:to-orange-700 transition flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add New Plan</span>
                    </a>
                </div>

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

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($plans as $plan)
                        <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-xl transition-all duration-300">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-gray-800">{{ $plan->name }}</h3>
                                @if($plan->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                    </span>
                                @endif
                            </div>
                            <div class="mb-4 text-center py-4 border-y border-gray-200">
                                <p class="text-4xl font-bold text-orange-500">₱{{ number_format($plan->price, 2) }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-tachometer-alt mr-1"></i>{{ $plan->speed }}
                                </p>
                                @if($plan->data_cap)
                                    <p class="text-xs text-gray-400 mt-1">
                                        <i class="fas fa-database mr-1"></i>{{ $plan->data_cap }}
                                    </p>
                                @endif
                            </div>
                            <p class="text-gray-600 text-sm mb-4">{{ $plan->description ?? 'No description available' }}</p>
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <a href="{{ route('admin.plans.edit', $plan) }}" class="text-green-600 hover:text-green-800 transition flex items-center space-x-1">
                                    <i class="fas fa-edit"></i>
                                    <span class="text-sm">Edit</span>
                                </a>
                                <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition flex items-center space-x-1">
                                        <i class="fas fa-trash"></i>
                                        <span class="text-sm">Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 col-span-full">
                            <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">No plans found.</p>
                            <a href="{{ route('admin.plans.create') }}" class="inline-block mt-4 bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                                <i class="fas fa-plus mr-2"></i>Create your first plan
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $plans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
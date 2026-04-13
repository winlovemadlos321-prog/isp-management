@extends('layouts.app')

@section('title', 'Edit Plan')

@section('content')
<div class="min-h-screen flex">
    @include('layouts.sidebar')
    @include('layouts.topbar')

  <div class="flex-1 ml-64">

        <div class="mt-20 py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-edit text-orange-500 mr-2"></i>Edit Plan: {{ $plan->name }}
                    </h2>
                    <a href="{{ route('admin.plans.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back</span>
                    </a>
                </div>

                <form action="{{ route('admin.plans.update', $plan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Plan Name *</label>
                            <input type="text" name="name" required value="{{ old('name', $plan->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price (₱) *</label>
                            <input type="number" name="price" required step="0.01" value="{{ old('price', $plan->price) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Speed *</label>
                            <input type="text" name="speed" required value="{{ old('speed', $plan->speed) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                            @error('speed') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data Cap</label>
                            <input type="text" name="data_cap" value="{{ old('data_cap', $plan->data_cap) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" placeholder="e.g., Unlimited or 500GB">
                            @error('data_cap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" placeholder="Describe the plan features and benefits...">{{ old('description', $plan->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500 focus:ring-orange-500 h-4 w-4">
                                <span class="text-sm text-gray-700">Active (Plan is available for customers)</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.plans.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition flex items-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Update Plan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
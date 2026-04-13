{{-- resources/views/admin/routers/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Router')

@section('content')
<div class="min-h-screen flex">
    @include('layouts.sidebar')

    <div class="flex-1 ml-64">
        @include('layouts.topbar')

        <div class="mt-16 py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-edit text-orange-500 mr-2"></i>Edit Router
                    </h2>
                    <a href="{{ route('admin.routers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>

                <form action="{{ route('admin.routers.update', $router) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Router Name *</label>
                            <input type="text" name="name" required value="{{ old('name', $router->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">IP Address *</label>
                            <input type="text" name="ip_address" required value="{{ old('ip_address', $router->ip_address) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            @error('ip_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">API Port *</label>
                            <input type="text" name="api_port" required value="{{ old('api_port', $router->api_port) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            @error('api_port') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                            <input type="text" name="username" required value="{{ old('username', $router->username) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500" placeholder="Leave blank to keep current password">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location', $router->location) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ $router->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500 shadow-sm">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Reset</button>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition">
                            <i class="fas fa-save mr-2"></i>Update Router
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
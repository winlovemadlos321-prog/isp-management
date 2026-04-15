<?php
// app/Http/Controllers/Admin/RouterController.php

namespace App\Http\Controllers\Admin;

use App\Models\Router;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouterController extends Controller
{
    public function index()
    {
        $routers = Router::latest()->paginate(10);
        return view('admin.routers.create', compact('routers'));
    }

    public function create()
    {
        return view('admin.routers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'api_port' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'location' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $router = Router::create($validated);
        
        Log::log('router_created', "Router {$router->name} was created", $router);

        return redirect()->route('admin.routers.index')
            ->with('success', 'Router created successfully!');
    }

    public function edit(Router $router)
    {
        return view('admin.routers.edit', compact('router'));
    }

    public function update(Request $request, Router $router)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'api_port' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'location' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $oldData = $router->toArray();
        $router->update($validated);
        
        Log::log('router_updated', "Router {$router->name} was updated", $router, $oldData, $router->toArray());

        return redirect()->route('admin.routers.index')
            ->with('success', 'Router updated successfully!');
    }

    public function destroy(Router $router)
    {
        if ($router->customers()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete router with assigned customers.');
        }
        
        $routerName = $router->name;
        $router->delete();
        
        Log::log('router_deleted', "Router {$routerName} was deleted", $router);
        
        return redirect()->route('admin.routers.index')
            ->with('success', 'Router deleted successfully!');
    }
}
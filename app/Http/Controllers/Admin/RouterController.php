<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Router;
use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function index()
    {
        $routers = Router::paginate(10);
        return view('admin.routers.index', compact('routers'));
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
            'username' => 'required|string',
            'password' => 'required|string',
            'location' => 'nullable|string',
            'port' => 'required|string',
        ]);
        
        Router::create($validated);
        
        return redirect()->route('admin.routers.index')->with('success', 'Router created successfully');
    }
    
    public function show(Router $router)
    {
        return view('admin.routers.show', compact('router'));
    }
    
    public function destroy(Router $router)
    {
        if($router->customers()->count() > 0) {
            return back()->with('error', 'Cannot delete router with connected customers');
        }
        
        $router->delete();
        return redirect()->route('admin.routers.index')->with('success', 'Router deleted successfully');
    }
}
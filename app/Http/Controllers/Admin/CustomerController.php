<?php
// app/Http/Controllers/Admin/CustomerController.php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Plan;
use App\Models\Router;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('router');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('customer_number', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            if ($request->status == 'active') {
                $query->where('is_active', true);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status == 'synced') {
                $query->where('status', 'synced');
            } elseif ($request->status == 'unsynced') {
                $query->where('status', 'unsynced');
            }
        }
        
        $customers = $query->latest()->paginate(10);
        
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        $plans = Plan::where('is_active', true)->get();
        $routers = Router::where('is_active', true)->get();
        return view('admin.customers.create', compact('plans', 'routers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'plan_name' => 'required|string',
            'plan_price' => 'required|numeric',
            'router_id' => 'nullable|exists:routers,id',
            'device' => 'required|in:none,V-SOL,Huawei,Assorted',
            'expiry_date' => 'required|date',
            'sync_now' => 'nullable|boolean'
        ]);

        // Create customer
        $customer = new Customer();
        $customer->name = $validated['name'];
        $customer->email = $validated['email'] ?? null;
        $customer->phone = $validated['phone'];
        $customer->address = $validated['address'];
        $customer->plan_name = $validated['plan_name'];
        $customer->plan_price = $validated['plan_price'];
        $customer->router_id = $validated['router_id'] ?? null;
        $customer->device = $validated['device'];
        $customer->expiry_date = $validated['expiry_date'];
        $customer->customer_number = $customer->generateCustomerNumber();
        $customer->is_active = true;
        $customer->status = 'unsynced';
        $customer->sync_completed = false;
        
        // Generate PPPoE credentials
        $customer->pppoe_username = $customer->generatePppoeUsername();
        $customer->pppoe_password = $customer->generatePppoePassword();
        
        $customer->save();

        // Sync if requested (optional - implement later)
        if ($request->has('sync_now') && $request->sync_now) {
            // $customer->syncWithMikrotik();
        }

        // Log the creation (commented out if Log model doesn't exist)
        // Log::log('customer_created', "Customer {$customer->name} was created", $customer);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully! Customer Number: ' . $customer->customer_number);
    }

    public function show(Customer $customer)
    {
        $customer->load('router', 'payments');
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $plans = Plan::where('is_active', true)->get();
        $routers = Router::where('is_active', true)->get();
        return view('admin.customers.edit', compact('customer', 'plans', 'routers'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'plan_name' => 'required|string',
            'plan_price' => 'required|numeric',
            'router_id' => 'nullable|exists:routers,id',
            'device' => 'required|in:none,V-SOL,Huawei,Assorted',
            'expiry_date' => 'required|date',
            'is_active' => 'nullable|boolean'
        ]);

        $customer->update($validated);
        
        // Log the update (commented out if Log model doesn't exist)
        // Log::log('customer_updated', "Customer {$customer->name} was updated", $customer);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    public function sync(Customer $customer)
    {
        // Implement MikroTik sync later
        return redirect()->back()->with('info', 'Sync feature coming soon!');
    }

    public function unsync(Customer $customer)
    {
        $customer->update(['status' => 'unsynced', 'sync_completed' => false]);
        return redirect()->back()->with('success', 'Customer unsynced successfully!');
    }

    public function destroy(Customer $customer)
    {
        $customerName = $customer->name;
        $customer->delete();
        
        // Log the deletion (commented out if Log model doesn't exist)
        // Log::log('customer_deleted', "Customer {$customerName} was deleted", $customer);
        
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }

    public function generateScript(Customer $customer)
    {
        $script = $customer->generateMikrotikScript();
        $customer->save();
        
        return response()->json([
            'script' => $script,
            'message' => 'Script generated successfully!'
        ]);
    }
}
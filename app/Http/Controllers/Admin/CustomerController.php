<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Router;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['plan', 'router'])->paginate(15);
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
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'plan_id' => 'required|exists:plans,id',
            'router_id' => 'nullable|exists:routers,id',
            'expiry_date' => 'required|date',
        ]);
        
        $validated['customer_number'] = 'CUS-' . str_pad(Customer::count() + 1, 6, '0', STR_PAD_LEFT);
        $validated['is_active'] = true;
        
        Customer::create($validated);
        
        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
    }
    
    public function show(Customer $customer)
    {
        $customer->load(['plan', 'router', 'payments']);
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
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'plan_id' => 'required|exists:plans,id',
            'router_id' => 'nullable|exists:routers,id',
            'expiry_date' => 'required|date',
            'is_active' => 'boolean',
        ]);
        
        $customer->update($validated);
        
        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
    }
    
    public function destroy(Customer $customer)
    {
        if($customer->payments()->count() > 0) {
            return back()->with('error', 'Cannot delete customer with payment history');
        }
        
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully');
    }
}
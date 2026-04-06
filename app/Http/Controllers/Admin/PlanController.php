<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::paginate(10);
        return view('admin.plans.index', compact('plans'));
    }
    
    public function create()
    {
        return view('admin.plans.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'speed' => 'required|string',
            'data_cap' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        
        Plan::create($validated);
        
        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully');
    }
    
    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }
    
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'speed' => 'required|string',
            'data_cap' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $plan->update($validated);
        
        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully');
    }
    
    public function destroy(Plan $plan)
    {
        if($plan->customers()->count() > 0) {
            return back()->with('error', 'Cannot delete plan with active customers');
        }
        
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully');
    }
}
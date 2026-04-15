<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class TicketDispatchController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('customer', 'technician')->latest()->paginate(15);
        $stats = [
            'total' => Ticket::count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'completed' => Ticket::where('status', 'completed')->count(),
        ];
        return view('admin.tickets.index', compact('tickets', 'stats'));
    }

    public function create()
{
    $customers = Customer::where('is_active', true)->orderBy('name')->get();
    $technicians = User::where('role', 'technician')->get();
    return view('admin.tickets.create', compact('customers', 'technicians'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'poll_number' => 'nullable|string|max:50',
            'nap_box_number' => 'nullable|string|max:50',
            'priority' => 'required|in:low,normal,high,urgent',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'scheduled_date' => 'nullable|date',
            'scheduled_time' => 'nullable',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);
        
        $ticket = new Ticket();
        $ticket->ticket_number = Ticket::generateTicketNumber();
        $ticket->customer_id = $customer->id;
        $ticket->customer_name = $customer->name;
        $ticket->customer_phone = $customer->phone;
        $ticket->customer_address = $customer->address;
        $ticket->plan_name = $customer->plan_name;
        $ticket->device_type = $customer->device;
        $ticket->poll_number = $validated['poll_number'];
        $ticket->nap_box_number = $validated['nap_box_number'];
        $ticket->priority = $validated['priority'];
        $ticket->description = $validated['description'];
        $ticket->assigned_to = $validated['assigned_to'] ?? null;
        $ticket->scheduled_date = $validated['scheduled_date'] ?? null;
        $ticket->scheduled_time = $validated['scheduled_time'] ?? null;
        $ticket->status = 'pending';
        
        $ticket->save();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket created successfully! Ticket #: ' . $ticket->ticket_number);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('customer', 'technician');
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $technicians = User::where('role', 'technician')->get();
        return view('admin.tickets.edit', compact('ticket', 'technicians'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'poll_number' => 'nullable|string|max:50',
            'nap_box_number' => 'nullable|string|max:50',
            'status' => 'required|in:pending,assigned,in_progress,completed,cancelled',
            'priority' => 'required|in:low,normal,high,urgent',
            'description' => 'nullable|string',
            'technician_notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'scheduled_date' => 'nullable|date',
            'scheduled_time' => 'nullable',
        ]);

        if ($validated['status'] === 'completed' && !$ticket->completed_at) {
            $validated['completed_at'] = now();
        }

        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket updated successfully!');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,assigned,in_progress,completed,cancelled'
        ]);

        if ($validated['status'] === 'completed' && !$ticket->completed_at) {
            $validated['completed_at'] = now();
        }

        $ticket->update($validated);

        return response()->json(['success' => true]);
    }
}
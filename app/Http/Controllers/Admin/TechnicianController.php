<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function dashboard()
    {
        $technicianName = strtolower(auth()->user()->name);
        
        $nameMapping = [
            'winlove' => 'winlove',
            'rj' => 'rj',
            'aleck' => 'aleck',
            'manong' => 'manong'
        ];
        
        $assignedName = $nameMapping[strtolower($technicianName)] ?? $technicianName;
        
        // Ticket statistics
        $ticketStats = [
            'total' => Ticket::where('assigned_to', $assignedName)->count(),
            'pending' => Ticket::where('assigned_to', $assignedName)->where('status', 'pending')->count(),
            'in_progress' => Ticket::where('assigned_to', $assignedName)->where('status', 'in_progress')->count(),
            'completed' => Ticket::where('assigned_to', $assignedName)->where('status', 'completed')->count(),
        ];
        
        // Get assigned tickets
        $assignedTickets = Ticket::where('assigned_to', $assignedName)
            ->latest()
            ->take(10)
            ->get();
        
        return view('technician.dashboard', compact('ticketStats', 'assignedTickets'));
    }

    public function tickets()
    {
        $technicianName = strtolower(auth()->user()->name);
        
        $nameMapping = [
            'winlove' => 'winlove',
            'rj' => 'rj',
            'aleck' => 'aleck',
            'manong' => 'manong'
        ];
        
        $assignedName = $nameMapping[strtolower($technicianName)] ?? $technicianName;
        
        $tickets = Ticket::where('assigned_to', $assignedName)
            ->latest()
            ->paginate(15);
        
        $stats = [
            'pending' => Ticket::where('assigned_to', $assignedName)->where('status', 'pending')->count(),
            'in_progress' => Ticket::where('assigned_to', $assignedName)->where('status', 'in_progress')->count(),
            'completed' => Ticket::where('assigned_to', $assignedName)->where('status', 'completed')->count(),
        ];
        
        return view('technician.tickets.index', compact('tickets', 'stats'));
    }

    public function updateTicketStatus(Request $request, Ticket $ticket)
    {
        $technicianName = strtolower(auth()->user()->name);
        
        $nameMapping = [
            'winlove' => 'winlove',
            'rj' => 'rj',
            'aleck' => 'aleck',
            'manong' => 'manong'
        ];
        
        $assignedName = $nameMapping[strtolower($technicianName)] ?? $technicianName;
        
        if ($ticket->assigned_to !== $assignedName) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $status = $request->status;
        
        if ($status === 'completed') {
            $ticket->status = 'completed';
            $ticket->completed_at = now();
        } else {
            $ticket->status = 'pending';
            $ticket->completed_at = null;
        }
        
        $ticket->save();
        
        return response()->json(['success' => true]);
    }
}
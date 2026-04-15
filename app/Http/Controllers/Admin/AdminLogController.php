<?php
// app/Http/Controllers/Admin/AdminLogController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminLogController extends Controller
{
    /**
     * Display a listing of admin logs. 
     */
    public function index(Request $request)
    {
        $query = AdminLog::query();

        // Apply filters
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        // Get statistics
        $stats = [
            'total_events' => AdminLog::count(),
            'successful_logins' => AdminLog::where('action_type', 'login')->where('status', 'success')->count(),
            'failed_attempts' => AdminLog::where('status', 'failed')->count(),
            'active_sessions' => $this->getActiveSessions(),
        ];

        // Get logs with pagination
        $perPage = $request->get('per_page', 15);
        $logs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Get recent activity for the sidebar
        $recentActivity = AdminLog::with('admin')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get unique action types for filter
        $actionTypes = AdminLog::distinct()->pluck('action_type');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $logs,
                'stats' => $stats,
                'recent_activity' => $recentActivity,
            ]);
        }

        return view('admin.logs.index', compact('logs', 'stats', 'recentActivity', 'actionTypes'));
    }

    /**
     * Store a newly created log entry.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|string|max:255',
            'action_type' => 'required|string|in:login,logout,create,update,delete,config,permission,network',
            'description' => 'required|string',
            'status' => 'required|string|in:success,failed,warning',
            'details' => 'nullable|array',
            'affected_resource_id' => 'nullable|integer',
            'affected_resource_type' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $logData = $validator->validated();
        
        // Add system information
        $logData['admin_id'] = auth()->id();
        $logData['admin_name'] = auth()->user()->name ?? 'System';
        $logData['admin_role'] = auth()->user()->role ?? 'Unknown';
        $logData['ip_address'] = $request->ip();
        $logData['user_agent'] = $request->userAgent();
        $logData['request_method'] = $request->method();
        $logData['request_url'] = $request->fullUrl();

        $log = AdminLog::create($logData);

        return response()->json([
            'success' => true,
            'message' => 'Log entry created successfully',
            'data' => $log
        ], 201);
    }

    /**
     * Display the specified log entry.
     */
    public function show($id)
    {
        $log = AdminLog::with('admin')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $log
        ]);
    }

    /**
     * Export logs to CSV or Excel.
     */
    public function export(Request $request)
    {
        $query = AdminLog::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        // Create CSV export
        $fileName = 'admin_logs_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'Admin Name', 'Admin Role', 'Action', 'Action Type', 
                'Description', 'IP Address', 'Status', 'Created At'
            ]);
            
            // Add data rows
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->admin_name,
                    $log->admin_role,
                    $log->action,
                    $log->action_type,
                    $log->description,
                    $log->ip_address,
                    $log->status,
                    $log->created_at
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get logs statistics for dashboard.
     */
    public function statistics(Request $request)
    {
        $days = $request->get('days', 30);
        $startDate = now()->subDays($days);

        $stats = [
            'total_logs' => AdminLog::where('created_at', '>=', $startDate)->count(),
            'by_action_type' => AdminLog::where('created_at', '>=', $startDate)
                ->select('action_type', DB::raw('count(*) as total'))
                ->groupBy('action_type')
                ->get(),
            'by_status' => AdminLog::where('created_at', '>=', $startDate)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'daily_logs' => AdminLog::where('created_at', '>=', $startDate)
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->limit(30)
                ->get(),
            'top_admins' => AdminLog::where('created_at', '>=', $startDate)
                ->select('admin_name', DB::raw('count(*) as total'))
                ->whereNotNull('admin_name')
                ->groupBy('admin_name')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get(),
            'top_ips' => AdminLog::where('created_at', '>=', $startDate)
                ->select('ip_address', DB::raw('count(*) as total'))
                ->groupBy('ip_address')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'period_days' => $days
        ]);
    }

    /**
     * Delete old logs (bulk delete).
     */
    public function deleteOldLogs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'days' => 'required|integer|min:1|max:365',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $cutoffDate = now()->subDays($request->days);
        $deletedCount = AdminLog::where('created_at', '<', $cutoffDate)->delete();

        // Log this action
        $this->store(new Request([
            'action' => 'Bulk delete old logs',
            'action_type' => 'delete',
            'description' => "Deleted {$deletedCount} log entries older than {$request->days} days",
            'status' => 'success',
            'details' => ['days' => $request->days, 'deleted_count' => $deletedCount]
        ]));

        return response()->json([
            'success' => true,
            'message' => "Deleted {$deletedCount} log entries older than {$request->days} days",
            'deleted_count' => $deletedCount
        ]);
    }

    /**
     * Get active sessions (simplified implementation).
     */
    private function getActiveSessions()
    {
        // This is a simplified version - you might want to implement proper session tracking
        $lastActivityThreshold = now()->subMinutes(15);
        return AdminLog::where('action_type', 'login')
            ->where('status', 'success')
            ->where('created_at', '>=', $lastActivityThreshold)
            ->distinct('admin_id')
            ->count('admin_id');
    }

    /**
     * Get single log entry for view/edit.
     */
    public function edit($id)
    {
        $log = AdminLog::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $log
        ]);
    }

    /**
     * Update log entry (usually for adding notes or flagging).
     */
    public function update(Request $request, $id)
    {
        $log = AdminLog::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string',
            'flagged' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $details = $log->details ?? [];
        if ($request->has('notes')) {
            $details['notes'] = $request->notes;
        }
        if ($request->has('flagged')) {
            $details['flagged'] = $request->flagged;
        }
        
        $log->details = $details;
        $log->save();

        return response()->json([
            'success' => true,
            'message' => 'Log entry updated successfully',
            'data' => $log
        ]);
    }

    /**
     * Remove the specified log entry.
     */
    public function destroy($id)
    {
        $log = AdminLog::findOrFail($id);
        $log->delete();

        // Log this deletion
        $this->store(new Request([
            'action' => 'Delete log entry',
            'action_type' => 'delete',
            'description' => "Deleted log entry #{$id} from admin {$log->admin_name}",
            'status' => 'success',
            'details' => ['deleted_log_id' => $id, 'original_log' => $log->toArray()]
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Log entry deleted successfully'
        ]);
    }
}
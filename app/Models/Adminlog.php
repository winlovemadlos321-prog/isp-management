<?php
// app/Models/AdminLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'admin_name',
        'admin_role',
        'action',
        'action_type',
        'description',
        'ip_address',
        'user_agent',
        'status',
        'details',
        'request_method',
        'request_url',
        'affected_resource_id',
        'affected_resource_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'details' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the admin that owns the log.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(admin::class, 'admin_id');
    }

    /**
     * Scope a query to only include logs of a specific action type.
     */
    public function scopeOfActionType($query, $type)
    {
        return $query->where('action_type', $type);
    }

    /**
     * Scope a query to only include logs of a specific status.
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include logs from a specific date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to search logs.
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('admin_name', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->orWhere('ip_address', 'like', "%{$searchTerm}%")
            ->orWhere('action', 'like', "%{$searchTerm}%");
        });
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'success' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'warning' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get action type badge class.
     */
    public function getActionTypeBadgeClassAttribute(): string
    {
        return match($this->action_type) {
            'login' => 'bg-green-100 text-green-800',
            'logout' => 'bg-gray-100 text-gray-800',
            'create' => 'bg-blue-100 text-blue-800',
            'update' => 'bg-yellow-100 text-yellow-800',
            'delete' => 'bg-red-100 text-red-800',
            'config' => 'bg-purple-100 text-purple-800',
            'permission' => 'bg-indigo-100 text-indigo-800',
            'network' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'customer_number', 'name', 'email', 'phone', 'address',
        'device_mac', 'device_ip', 'firmware_version', 'service_notes',
        'plan_id', 'router_id', 'installation_date', 'expiry_date', 'is_active'
    ];
    
    protected $casts = [
        'installation_date' => 'date',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];
    
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
    
    public function router(): BelongsTo
    {
        return $this->belongsTo(Router::class);
    }
    
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
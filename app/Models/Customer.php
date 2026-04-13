<?php
// app/Models/Customer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_number',
        'name',
        'email',           // Added email field
        'phone',
        'address',
        'plan_name',
        'plan_price',
        'pppoe_username',
        'pppoe_password',
        'router_id',
        'device',
        'status',
        'mikrotik_script',  // Added mikrotik_script field
        'installation_date',
        'expiry_date',
        'is_active',
        'sync_completed',
        'device_mac',
        'device_ip',
        'service_notes'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sync_completed' => 'boolean',
        'installation_date' => 'date',
        'expiry_date' => 'date',
        'plan_price' => 'decimal:2',
    ];

    protected $hidden = ['pppoe_password'];

    // Auto-generate credentials when creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            // Generate customer number if not set
            if (!$customer->customer_number) {
                $customer->customer_number = $customer->generateCustomerNumber();
            }
            
            // Generate PPPoE username if not set
            if (!$customer->pppoe_username) {
                $customer->pppoe_username = $customer->generatePppoeUsername();
            }
            
            // Generate PPPoE password if not set
            if (!$customer->pppoe_password) {
                $customer->pppoe_password = $customer->generatePppoePassword();
            }
            
            // Set default status if not set
            if (!$customer->status) {
                $customer->status = 'unsynced';
            }
            
            // Set default is_active if not set
            if ($customer->is_active === null) {
                $customer->is_active = true;
            }
            
            // Set default sync_completed if not set
            if ($customer->sync_completed === null) {
                $customer->sync_completed = false;
            }
            
            // Set default device if not set
            if (!$customer->device) {
                $customer->device = 'none';
            }
        });
    }

    // Relationships
    public function router()
    {
        return $this->belongsTo(Router::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Generate customer number
    public function generateCustomerNumber()
    {
        $prefix = 'CUST';
        $year = date('Y');
        $month = date('m');
        
        $lastCustomer = Customer::whereYear('created_at', $year)
                                 ->whereMonth('created_at', $month)
                                 ->orderBy('id', 'desc')
                                 ->first();
        
        if ($lastCustomer && $lastCustomer->customer_number) {
            $lastNumber = intval(substr($lastCustomer->customer_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "{$prefix}-{$year}{$month}-{$newNumber}";
    }

    // Generate PPPoE username
    public function generatePppoeUsername()
    {
        // Generate username from full name (lowercase, no spaces)
        $username = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $this->name));
        $baseUsername = $username;
        $counter = 1;
        
        while (Customer::where('pppoe_username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        return $username;
    }

    // Generate PPPoE password
    public function generatePppoePassword()
    {
        // Generate random secure password (12 characters)
        return bin2hex(random_bytes(6));
    }

    // Scopes
    public function scopeSynced($query)
    {
        return $query->where('status', 'synced');
    }

    public function scopeUnsynced($query)
    {
        return $query->where('status', 'unsynced');
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Router extends Model
{
    protected $fillable = ['name', 'ip_address', 'username', 'password', 'location', 'port', 'is_active'];
    
    protected $hidden = ['password'];
    protected $casts = ['is_active' => 'boolean'];
    
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
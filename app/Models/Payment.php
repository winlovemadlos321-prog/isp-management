<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'receipt_number', 
        'customer_id', 
        'amount', 
        'payment_method',
        'payment_date', 
        'payment_for_month', 
        'reference_number',  // Added reference_number
        'notes', 
        'received_by', 
        'is_reconciled'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'is_reconciled' => 'boolean',
        // Remove 'payment_for_month' as date since it's a string
    ];
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }
    
    // Accessor to format payment_for_month nicely
    public function getPaymentForMonthAttribute($value)
    {
        if ($value && strtotime($value)) {
            return date('F Y', strtotime($value));
        }
        return $value;
    }
}
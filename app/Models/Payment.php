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
        'reference_number',
        'notes', 
        'received_by', 
        'is_reconciled',
        'extend_months'  // Added extend_months field
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'is_reconciled' => 'boolean',
        'extend_months' => 'integer'
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
    
    // Accessor to format payment date nicely
    public function getFormattedPaymentDateAttribute()
    {
        return $this->payment_date->format('F d, Y');
    }
    
    // Accessor to format amount with peso sign
    public function getFormattedAmountAttribute()
    {
        return '₱' . number_format($this->amount, 2);
    }
    
    // Scope for today's payments
    public function scopeToday($query)
    {
        return $query->whereDate('payment_date', now()->toDateString());
    }
    
    // Scope for current month payments
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('payment_date', now()->month)
                     ->whereYear('payment_date', now()->year);
    }
    
    // Scope for payments by customer
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }
    
    // Scope for payments by method
    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }
    
    // Scope for reconciled payments
    public function scopeReconciled($query)
    {
        return $query->where('is_reconciled', true);
    }
    
    // Scope for pending reconciliation
    public function scopePending($query)
    {
        return $query->where('is_reconciled', false);
    }
}
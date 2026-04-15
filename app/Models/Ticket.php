<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'ticket_number',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'plan_name',
        'device_type',
        'poll_number',
        'nap_box_number',
        'status',
        'priority',
        'description',
        'technician_notes',
        'assigned_to',
        'scheduled_date',
        'scheduled_time',
        'completed_at'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_at' => 'datetime'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public static function generateTicketNumber()
    {
        $prefix = 'TKT';
        $year = date('Y');
        $month = date('m');
        
        $lastTicket = self::whereYear('created_at', $year)
                          ->whereMonth('created_at', $month)
                          ->orderBy('id', 'desc')
                          ->first();
        
        if ($lastTicket && $lastTicket->ticket_number) {
            $lastNumber = intval(substr($lastTicket->ticket_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "{$prefix}-{$year}{$month}-{$newNumber}";
    }
}
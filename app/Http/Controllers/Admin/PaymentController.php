<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['customer', 'receiver'])->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }
    
    public function show(Payment $payment)
    {
        $payment->load(['customer', 'receiver']);
        return view('admin.payments.show', compact('payment'));
    }
    
    public function reconcile(Payment $payment)
    {
        $payment->update(['is_reconciled' => true]);
        
        return back()->with('success', 'Payment reconciled successfully');
    }
}
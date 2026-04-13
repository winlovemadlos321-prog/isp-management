<?php
// app/Http/Controllers/Admin/PaymentController.php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Customer;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('customer')->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function reconcile(Payment $payment)
    {
        $payment->is_reconciled = true;
        $payment->save();

        Log::log('payment_reconciled', "Payment {$payment->receipt_number} was reconciled", $payment);

        return redirect()->back()->with('success', 'Payment reconciled successfully!');
    }
}
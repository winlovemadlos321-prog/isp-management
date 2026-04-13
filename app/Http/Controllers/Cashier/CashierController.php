<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashierController extends Controller
{
    public function dashboard()
    {
        $todayPayments = Payment::whereDate('payment_date', Carbon::today())->sum('amount');
        $monthlyPayments = Payment::whereMonth('payment_date', Carbon::now()->month)->sum('amount');
        $totalCustomers = Customer::count();
        $todayTransactions = Payment::whereDate('payment_date', Carbon::today())->count();
        $recentPayments = Payment::with('customer')->latest()->take(5)->get();
        
        return view('cashier.dashboard', compact('todayPayments', 'monthlyPayments', 'totalCustomers', 'todayTransactions', 'recentPayments'));
    }

    public function customers(Request $request)
    {
        $query = Customer::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('customer_number', 'like', "%{$search}%");
            });
        }
        
        $customers = $query->latest()->paginate(15);
        return view('cashier.customers.index', compact('customers'));
    }

    public function showCustomer(Customer $customer)
    {
        $payments = $customer->payments()->latest()->paginate(10);
        return view('cashier.customers.show', compact('customer', 'payments'));
    }

    public function createPayment()
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        return view('cashier.payments.create', compact('customers'));
    }

    public function getCustomerDetails($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json([
            'customer_number' => $customer->customer_number,
            'plan_name' => $customer->plan_name,
            'plan_price' => $customer->plan_price,
            'name' => $customer->name
        ]);
    }

    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,card,bank_transfer,gcash',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        
        try {
            $customer = Customer::findOrFail($validated['customer_id']);
            
            // Generate receipt number
            $receiptNumber = 'RCP-' . date('Ymd') . '-' . str_pad(Payment::count() + 1, 4, '0', STR_PAD_LEFT);
            
            // Create payment
            $payment = Payment::create([
                'receipt_number' => $receiptNumber,
                'customer_id' => $validated['customer_id'],
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'payment_date' => $validated['payment_date'],
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'],
                'payment_for_month' => date('Y-m-d'),
                'is_reconciled' => true,
                'received_by' => auth()->id()
            ]);
            
            // Update customer expiry date (add 1 month)
            $newExpiryDate = Carbon::parse($customer->expiry_date)->addMonth();
            $customer->update(['expiry_date' => $newExpiryDate]);
            
            DB::commit();
            
            return redirect()->route('cashier.payments.receipt', $payment)
                ->with('success', 'Payment recorded successfully! Receipt #: ' . $receiptNumber);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to record payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function paymentHistory(Request $request)
    {
        $query = Payment::with('customer');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('customer_number', 'like', "%{$search}%");
            });
        }
        
        $payments = $query->latest()->paginate(15);
        return view('cashier.payments.history', compact('payments'));
    }

    public function printReceipt(Payment $payment)
    {
        $payment->load('customer');
        return view('cashier.payments.receipt', compact('payment'));
    }

    public function customerPaymentHistory(Customer $customer)
    {
        $payments = $customer->payments()->latest()->paginate(10);
        return view('cashier.customers.payments', compact('customer', 'payments'));
    }

    // YOUR DAILY REPORT METHOD - KEPT EXACTLY AS YOU HAVE IT
    public function dailyReport(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        
        $payments = Payment::with('customer')
            ->whereDate('payment_date', $date)
            ->get();
        
        $totalAmount = $payments->sum('amount');
        $totalTransactions = $payments->count();
        
        $cashTotal = $payments->where('payment_method', 'cash')->sum('amount');
        $cardTotal = $payments->where('payment_method', 'card')->sum('amount');
        $bankTransferTotal = $payments->where('payment_method', 'bank_transfer')->sum('amount');
        $gcashTotal = $payments->where('payment_method', 'gcash')->sum('amount');
        
        if ($request->ajax()) {
            return view('cashier.partials.daily-report', compact('date', 'payments', 'totalAmount', 'totalTransactions', 'cashTotal', 'cardTotal', 'bankTransferTotal', 'gcashTotal'));
        }
        
        return view('cashier.daily-report', compact('date', 'payments', 'totalAmount', 'totalTransactions', 'cashTotal', 'cardTotal', 'bankTransferTotal', 'gcashTotal'));
    }
}
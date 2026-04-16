<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\RouterController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\Admin\AdminLogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Technician\TechnicianController;
use App\Http\Controllers\Admin\TicketDispatchController;  
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home Route
Route::get('/', function () {
    if (auth()->check()) {
        $role = session('user_role', 'admin');
        if ($role === 'cashier') {
            return redirect()->route('cashier.dashboard');
        } elseif ($role === 'technician') {
            return redirect()->route('technician.dashboard');
        }
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('plans', PlanController::class);
    Route::resource('routers', RouterController::class);
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/reconcile', [PaymentController::class, 'reconcile'])->name('payments.reconcile');
    Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');

    // TICKET DISPATCH ROUTES
    Route::resource('tickets', TicketDispatchController::class);
    Route::patch('/tickets/{ticket}/status', [TicketDispatchController::class, 'updateStatus'])->name('tickets.status');
    //Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.settings');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('admin.settings.updateProfile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('admin.settings.updatePassword');
});

// Cashier Routes
Route::middleware(['auth'])->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/dashboard', [CashierController::class, 'dashboard'])->name('dashboard');
    Route::get('/customers', [CashierController::class, 'customers'])->name('customers.index');
    Route::get('/customers/{customer}', [CashierController::class, 'showCustomer'])->name('customers.show');
    Route::get('/customers/{customer}/payments', [CashierController::class, 'customerPaymentHistory'])->name('customers.payments');
    Route::get('/payments/create', [CashierController::class, 'createPayment'])->name('payments.create');
    Route::post('/payments', [CashierController::class, 'storePayment'])->name('payments.store');
    Route::get('/payments/history', [CashierController::class, 'paymentHistory'])->name('payments.history');
    Route::get('/payments/{payment}/receipt', [CashierController::class, 'printReceipt'])->name('payments.receipt');
    Route::get('/payments/{payment}/print', [CashierController::class, 'printReceipt'])->name('payments.print');
    Route::get('/api/customers/{id}/details', [CashierController::class, 'getCustomerDetails'])->name('api.customer.details');
});

// Technician Routes
Route::middleware(['auth'])->prefix('technician')->name('technician.')->group(function () {
    Route::get('/dashboard', [TechnicianController::class, 'dashboard'])->name('dashboard');
    Route::get('/tickets', [TechnicianController::class, 'tickets'])->name('tickets.index');
    Route::patch('/tickets/{ticket}/status', [TechnicianController::class, 'updateTicketStatus'])->name('tickets.status');
});

// Daily Report Route
Route::get('/daily-report', [CashierController::class, 'dailyReport'])->name('cashier.daily.report');
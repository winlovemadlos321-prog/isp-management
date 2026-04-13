    <?php

    use App\Http\Controllers\Admin\CustomerController;
    use App\Http\Controllers\Admin\DashboardController;
    use App\Http\Controllers\Admin\PlanController;
    use App\Http\Controllers\Admin\RouterController;
    use App\Http\Controllers\Admin\PaymentController;
    use App\Http\Controllers\Cashier\CashierController;
    use App\Http\Controllers\Admin\UserController;
    use App\Http\Controllers\Technician\TechnicianController;
    use App\Http\Controllers\Auth\LoginController;
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
        Route::resource('customers', CustomerController::class);  // Changed to plural
        Route::resource('plans', PlanController::class);
        Route::resource('routers', RouterController::class);
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/{payment}/reconcile', [PaymentController::class, 'reconcile'])->name('payments.reconcile');
    });

    // Cashier Routes
    Route::middleware(['auth'])->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/dashboard', [CashierController::class, 'dashboard'])->name('dashboard');
        Route::get('/customers', [CashierController::class, 'customer'])->name('customer.index');
        Route::get('/customers/create', [CashierController::class, 'createCustomer'])->name('customers.create');
        Route::post('/customers', [CashierController::class, 'storeCustomer'])->name('customers.store');
        Route::get('/payments/create', [CashierController::class, 'createPayment'])->name('payments.create');
        Route::post('/payments', [CashierController::class, 'storePayment'])->name('payments.store');
        Route::get('/payments/history', [CashierController::class, 'paymentHistory'])->name('payments.history');
    });

    // Technician Routes
    Route::middleware(['auth'])->prefix('technician')->name('technician.')->group(function () {
        Route::get('/dashboard', [TechnicianController::class, 'dashboard'])->name('dashboard');
        Route::get('/customers', [TechnicianController::class, 'customers'])->name('customers.index');
        Route::get('/customers/{customer}', [TechnicianController::class, 'showCustomer'])->name('customers.show');
        Route::put('/customers/{customer}/device', [TechnicianController::class, 'updateDevice'])->name('customers.update-device');
        Route::post('/customers/{customer}/notes', [TechnicianController::class, 'addServiceNote'])->name('customers.add-note');
    });

    // Cashier Routes
    Route::middleware(['auth'])->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/dashboard', [CashierController::class, 'dashboard'])->name('dashboard');
        
        // Customer routes (view only)
        Route::get('/customers', [CashierController::class, 'customers'])->name('customers.index');
        Route::get('/customers/{customer}', [CashierController::class, 'showCustomer'])->name('customers.show');
        Route::get('/customers/{customer}/payments', [CashierController::class, 'customerPaymentHistory'])->name('customers.payments');
        
        // Payment routes
        Route::get('/payments/create', [CashierController::class, 'createPayment'])->name('payments.create');
        Route::post('/payments', [CashierController::class, 'storePayment'])->name('payments.store');
        Route::get('/payments/history', [CashierController::class, 'paymentHistory'])->name('payments.history');
        Route::get('/payments/{payment}/receipt', [CashierController::class, 'printReceipt'])->name('payments.receipt');
        Route::get('/payments/{payment}/print', [CashierController::class, 'printReceipt'])->name('payments.print');
        
        // API route for customer details
        Route::get('/api/customers/{id}/details', [CashierController::class, 'getCustomerDetails'])->name('api.customer.details');
    });

    //daily report routes
Route::get('/daily-report', [CashierController::class, 'dailyReport'])->name('cashier.daily.report');
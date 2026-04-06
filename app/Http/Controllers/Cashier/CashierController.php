<?php
namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

class CashierController extends Controller
{
    public function dashboard()
    {
        return view('cashier.dashboard');
    }
}
<?php
namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;

class TechnicianController extends Controller
{
    public function dashboard()
    {
        return view('technician.dashboard');
    }
}
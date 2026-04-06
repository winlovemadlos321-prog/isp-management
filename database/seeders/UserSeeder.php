<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing users first (optional)
        User::truncate();
        
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@isp.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        
        // Create Cashier User
        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@isp.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        
        // Create Technician User
        User::create([
            'name' => 'Technician User',
            'email' => 'tech@isp.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
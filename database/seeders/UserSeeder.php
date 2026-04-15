<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@isp.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        // Create Cashier User
        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@isp.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'email_verified_at' => now(),
        ]);
        
        // Create Technician User
        User::create([
            'name' => 'Technician User',
            'email' => 'tech@isp.com',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'email_verified_at' => now(),
        ]);
    }
}
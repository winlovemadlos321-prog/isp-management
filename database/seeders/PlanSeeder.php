<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Basic',
            'price' => 29.99,
            'speed' => '10 Mbps',
            'data_cap' => '100 GB',
            'description' => 'Basic plan for light users',
            'is_active' => true
        ]);
        
        Plan::create([
            'name' => 'Standard',
            'price' => 49.99,
            'speed' => '25 Mbps',
            'data_cap' => 'Unlimited',
            'description' => 'Standard plan for family users',
            'is_active' => true
        ]);
        
        Plan::create([
            'name' => 'Premium',
            'price' => 79.99,
            'speed' => '50 Mbps',
            'data_cap' => 'Unlimited',
            'description' => 'Premium plan for heavy users',
            'is_active' => true
        ]);
    }
}
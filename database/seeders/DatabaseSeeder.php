<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        $this->call([
            UserSeeder::class,  // This creates admin, cashier, technician
            // Add other seeders here
            FakeUsersSeeder::class,   // ← add this
            // any other seeders...
        ]);
    }
}
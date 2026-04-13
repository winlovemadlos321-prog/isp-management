<?php
// database/migrations/2024_01_01_000002_create_plans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('speed');
            $table->string('data_cap')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Insert default plans
        DB::table('plans')->insert([
            [
                'name' => '20 Mbps',
                'price' => 1000,
                'speed' => '20 Mbps',
                'description' => 'Basic plan for light users',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '30 Mbps',
                'price' => 1300,
                'speed' => '30 Mbps',
                'description' => 'Standard plan for family users',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '50 Mbps',
                'price' => 1500,
                'speed' => '50 Mbps',
                'description' => 'Premium plan for heavy users',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
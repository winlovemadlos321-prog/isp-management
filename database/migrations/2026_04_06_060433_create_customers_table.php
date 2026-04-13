<?php
// database/migrations/2024_01_01_000001_create_customers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_number')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('address');
            $table->string('plan_name');
            $table->decimal('plan_price', 10, 2);
            $table->string('pppoe_username')->unique();
            $table->string('pppoe_password');
            $table->foreignId('router_id')->nullable()->constrained()->onDelete('set null');
            $table->string('device')->default('none'); // V-SOL, Huawei, Assorted, None
            $table->string('status')->default('unsynced'); // synced, unsynced
            $table->text('mikrotik_script')->nullable();
            $table->date('installation_date')->nullable();
            $table->date('expiry_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('sync_completed')->default(false);
            $table->string('device_mac')->nullable();
            $table->string('device_ip')->nullable();
            $table->text('service_notes')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('pppoe_username');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
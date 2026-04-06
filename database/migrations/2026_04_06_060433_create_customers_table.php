<?php

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
            $table->string('device_mac')->nullable();
            $table->string('device_ip')->nullable();
            $table->string('firmware_version')->nullable();
            $table->text('service_notes')->nullable();
            $table->foreignId('plan_id')->constrained()->onDelete('restrict');
            $table->foreignId('router_id')->nullable()->constrained()->onDelete('set null');
            $table->date('installation_date')->nullable();
            $table->date('expiry_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('admin_role')->nullable();
            $table->string('action');
            $table->string('action_type'); // login, logout, create, update, delete, config, permission, network
            $table->text('description');
            $table->string('ip_address', 45);
            $table->string('user_agent')->nullable();
            $table->string('status'); // success, failed, warning
            $table->json('details')->nullable();
            $table->string('request_method')->nullable();
            $table->string('request_url')->nullable();
            $table->unsignedBigInteger('affected_resource_id')->nullable();
            $table->string('affected_resource_type')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('admin_id');
            $table->index('action_type');
            $table->index('status');
            $table->index('ip_address');
            $table->index('created_at');
            $table->index(['admin_id', 'created_at']);
            $table->index(['action_type', 'created_at']);
            
            // REMOVE THIS FOREIGN KEY CONSTRAINT IF admins TABLE DOESN'T EXIST
            // $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};
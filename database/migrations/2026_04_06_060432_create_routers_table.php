<?php
// database/migrations/2024_01_01_000003_create_routers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address');
            $table->string('api_port')->default('8728');
            $table->string('username');
            $table->string('password');
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Insert default router
        DB::table('routers')->insert([
            'name' => 'Main MikroTik Router',
            'ip_address' => '192.168.88.1',
            'api_port' => '8728',
            'username' => 'admin',
            'password' => 'password',
            'location' => 'Main Data Center',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('routers');
    }
};
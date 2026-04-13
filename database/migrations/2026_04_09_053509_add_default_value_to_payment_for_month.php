<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Set default value for existing records and new ones
            DB::statement('ALTER TABLE payments MODIFY payment_for_month VARCHAR(255) DEFAULT "Unknown"');
        });
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE payments MODIFY payment_for_month VARCHAR(255) NOT NULL');
    }
};
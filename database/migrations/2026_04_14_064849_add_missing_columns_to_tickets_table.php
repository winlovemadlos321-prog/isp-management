<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Check and add missing columns
            if (!Schema::hasColumn('tickets', 'status')) {
                $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('pending')->after('nap_box_number');
            }
            if (!Schema::hasColumn('tickets', 'priority')) {
                $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->after('status');
            }
            if (!Schema::hasColumn('tickets', 'description')) {
                $table->text('description')->nullable()->after('priority');
            }
            if (!Schema::hasColumn('tickets', 'technician_notes')) {
                $table->text('technician_notes')->nullable()->after('description');
            }
            if (!Schema::hasColumn('tickets', 'assigned_to')) {
                $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null')->after('technician_notes');
            }
            if (!Schema::hasColumn('tickets', 'scheduled_date')) {
                $table->date('scheduled_date')->nullable()->after('assigned_to');
            }
            if (!Schema::hasColumn('tickets', 'scheduled_time')) {
                $table->time('scheduled_time')->nullable()->after('scheduled_date');
            }
            if (!Schema::hasColumn('tickets', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('scheduled_time');
            }
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['status', 'priority', 'description', 'technician_notes', 'assigned_to', 'scheduled_date', 'scheduled_time', 'completed_at']);
        });
    }
};
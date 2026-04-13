<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'receipt_number')) {
                $table->string('receipt_number')->unique()->after('id');
            }
            if (!Schema::hasColumn('payments', 'payment_method')) {
                $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'gcash'])->default('cash')->after('amount');
            }
            if (!Schema::hasColumn('payments', 'reference_number')) {
                $table->string('reference_number')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('payments', 'notes')) {
                $table->text('notes')->nullable()->after('reference_number');
            }
            if (!Schema::hasColumn('payments', 'received_by')) {
                $table->foreignId('received_by')->nullable()->constrained('users')->after('notes');
            }
            if (!Schema::hasColumn('payments', 'is_reconciled')) {
                $table->boolean('is_reconciled')->default(false)->after('received_by');
            }
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['receipt_number', 'payment_method', 'reference_number', 'notes', 'received_by', 'is_reconciled']);
        });
    }
};
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
        Schema::table('tsr_account_due_daily_reports', function (Blueprint $table) {
            $table->string('dependency_name')->nullable()->after('cashier');
            $table->string('concept')->nullable()->after('dependency_name');
        });

        Schema::table('tsr_account_due_custome_reports', function (Blueprint $table) {
            $table->string('dependency_name')->nullable()->after('cashier');
            $table->string('concept')->nullable()->after('dependency_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tsr_account_due_custome_reports', function (Blueprint $table) {
            $table->dropColumn(['dependency_name', 'concept']);
        });

        Schema::table('tsr_account_due_daily_reports', function (Blueprint $table) {
            $table->dropColumn(['dependency_name', 'concept']);
        });
    }
};

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
        Schema::table('tsr_account_due_provisional_integers', function (Blueprint $table) {
            $table->unsignedBigInteger('backoffice_dependency_id')->nullable()->after('account_due_profile_id');
            $table->string('status')->default('generado')->after('type');
        });

        Schema::table('tsr_account_due_income_receipts', function (Blueprint $table) {
            $table->decimal('total_transfer', 10, 2)->default(0.00)->after('total_check');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tsr_account_due_income_receipts', function (Blueprint $table) {
            $table->dropColumn('total_transfer');
        });

        Schema::table('tsr_account_due_provisional_integers', function (Blueprint $table) {
            $table->dropColumn(['backoffice_dependency_id', 'status']);
        });
    }
};

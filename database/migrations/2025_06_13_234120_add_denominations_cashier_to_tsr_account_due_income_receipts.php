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
        Schema::table('tsr_account_due_income_receipts', function (Blueprint $table) {

            $table->string('denominations_cashier')->nullable();
            $table->string('denominations_payed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tsr_account_due_income_receipts', function (Blueprint $table) {

            $table->dropColumn('denominations_cashier');
            $table->dropColumn('denominations_payed');
        });
    }
};

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
        Schema::create('tsr_cashier_daily_cuts', function (Blueprint $table) {
            $table->id();
            $table->date('cut_date')->index();
            $table->string('cashier')->nullable();
            $table->string('cashier_user')->nullable();
            $table->decimal('total_cash', 12, 2)->default(0);
            $table->json('denominations')->nullable();
            $table->string('denominations_cashier')->nullable();
            $table->string('denominations_payed')->nullable();
            $table->timestamps();

            $table->unique(['cut_date', 'cashier'], 'tsr_cashier_daily_cuts_date_cashier_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_cashier_daily_cuts');
    }
};

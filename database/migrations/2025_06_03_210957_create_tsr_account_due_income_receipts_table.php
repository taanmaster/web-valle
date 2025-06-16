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
        Schema::create('tsr_account_due_income_receipts', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('account_due_income_id')->unsigned();

            $table->string('cashier_user')->nullable();
            $table->string('cashier')->nullable();
            $table->string('qty_text')->nullable();
            $table->integer('qty_integer')->nullable();
            $table->string('depositor')->nullable();

            // Totales de ingreso a partir del metodo de pago
            $table->decimal('total_cash', 10, 2)->default(0.00);
            // Total de efectivo
            $table->json('denominations')->nullable();

            $table->decimal('total_card', 10, 2)->default(0.00);
            $table->decimal('total_check', 10, 2)->default(0.00);


            $table->string('account')->nullable();
            $table->string('total')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_account_due_income_receipts');
    }
};

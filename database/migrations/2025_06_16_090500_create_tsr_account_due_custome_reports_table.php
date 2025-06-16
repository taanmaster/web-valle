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
        Schema::create('tsr_account_due_custome_reports', function (Blueprint $table) {
            $table->id();

            $table->string('cashier_user')->nullable();
            $table->string('cashier')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('account')->nullable();

            $table->json('payment_methods')->nullable(); // Ejemplo: ["efectivo", "tarjeta"]
            $table->json('responsible_users')->nullable(); // Ejemplo: ["Juan", "María"]

            $table->string('filter')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_account_due_custome_reports');
    }
};

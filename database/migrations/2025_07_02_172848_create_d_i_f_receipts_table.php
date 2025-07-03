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
        Schema::create('d_i_f_receipts', function (Blueprint $table) {
            $table->id();

            $table->string('receipt_num')->unique();
            $table->date('receipt_date');
            $table->string('pacient_id');

            $table->string('appointment')->nullable();
            $table->string('location')->nullable();

            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);

            $table->string('payment_method')->default('cash');

            $table->string('issued_by');
            $table->string('status')->default('completed'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_receipts');
    }
};

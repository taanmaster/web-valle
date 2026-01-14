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
        Schema::create('identification_certificate_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('certificate_id');

            $table->string('folio', 10)->unique();
            $table->string('receipt_number')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('proof_filename')->nullable();
            $table->string('status');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identification_certificate_payments');
    }
};

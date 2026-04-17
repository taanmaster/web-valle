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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('folio', 10)->unique();
            $table->decimal('total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->string('payment_method');   // oxxopay | banbajio
            $table->string('payment_status')->default('Pago Pendiente');  // Pago Pendiente | Referencia Expirada | Pagado
            $table->string('delivery_status')->default('Pendiente');      // Pendiente | Entregado | Cancelado
            $table->string('payment_id')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('payment_url', 500)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

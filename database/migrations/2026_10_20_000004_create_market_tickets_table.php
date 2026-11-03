<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Boleta (entero provisional para pago): una por mes cobrado, se paga en ventanilla al emitirse
        Schema::create('market_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('series', 2);
            $table->unsignedInteger('folio');
            $table->foreignId('market_stall_id')->constrained('market_stalls');
            // Mes que paga (día 1 del mes)
            $table->date('period');
            // Copia de la tarifa al momento de emitir: la boleta conserva su monto y fundamento
            $table->decimal('amount', 10, 2);
            $table->unsignedSmallInteger('fiscal_year');
            $table->string('article', 10);
            $table->string('subsection', 10);
            $table->string('fraction', 10);
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('cancelled_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('cancel_reason')->nullable();

            $table->foreignId('market_cut_id')->nullable()->constrained('market_cuts')->nullOnDelete();

            // Recibo oficial que devuelve Tesorería
            $table->string('receipt_name')->nullable();
            $table->text('receipt_s3_url')->nullable();
            $table->timestamp('receipt_attached_at')->nullable();
            $table->foreignId('receipt_attached_by')->nullable()->constrained('users')->nullOnDelete();

            // Entrega del recibo al locatario
            $table->date('delivered_at')->nullable();
            $table->string('delivered_to')->nullable();
            $table->text('delivery_proof_s3_url')->nullable();
            $table->text('delivery_notes')->nullable();
            $table->foreignId('delivered_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->unique(['series', 'folio']);
            $table->index(['market_stall_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_tickets');
    }
};

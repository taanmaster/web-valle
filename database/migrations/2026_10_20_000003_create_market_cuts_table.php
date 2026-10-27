<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Corte diario: se cierra y se entrega a Tesorería en un solo paso
        Schema::create('market_cuts', function (Blueprint $table) {
            $table->id();
            $table->date('cut_date');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('tickets_count');
            $table->decimal('system_total', 12, 2);
            $table->decimal('cash_counted', 12, 2);
            $table->string('treasury_received_by');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_cuts');
    }
};

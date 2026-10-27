<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Padrón: un registro por espacio asignado a un locatario
        Schema::create('market_stalls', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('tenant_name');
            $table->string('phone', 20);
            $table->string('space_type');
            $table->string('space_number');
            $table->string('aisle')->nullable();
            $table->string('location');
            $table->string('business');
            $table->foreignId('market_rate_id')->constrained('market_rates');
            $table->date('registered_at');
            // Primer mes que debe pagar (día 1 del mes)
            $table->date('billing_start');
            // activo · baja
            $table->string('status')->default('activo');
            $table->timestamp('deactivated_at')->nullable();
            $table->foreignId('deactivated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Bitácora de gestiones de cobro
        Schema::create('market_collection_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_stall_id')->constrained('market_stalls')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date');
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_collection_notes');
        Schema::dropIfExists('market_stalls');
    }
};

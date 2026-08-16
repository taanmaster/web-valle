<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Vale de entrega de planta de una solicitud de Donación.
     * Registro interno de la Dirección: no genera PDF ni se muestra al ciudadano.
     */
    public function up(): void
    {
        Schema::create('environment_delivery_vouchers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('environment_request_id');
            $table->string('lugar_plantacion')->nullable();
            $table->date('fecha_entrega')->nullable();

            $table->timestamps();

            $table->index('environment_request_id');
        });

        Schema::create('environment_delivery_voucher_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('environment_delivery_voucher_id');
            $table->string('especie')->nullable();
            $table->string('cantidad')->nullable();

            $table->timestamps();

            $table->index('environment_delivery_voucher_id', 'edvi_voucher_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('environment_delivery_voucher_items');
        Schema::dropIfExists('environment_delivery_vouchers');
    }
};

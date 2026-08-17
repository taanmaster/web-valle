<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bandeja de mensajes del ciudadano. Genérica y reusable por cualquier
     * dependencia: nace del botón "Contactar al Solicitante" de Medio
     * Ambiente, pero no depende de ese módulo.
     */
    public function up(): void
    {
        Schema::create('citizen_messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sent_by')->nullable();

            $table->string('subject');
            $table->text('body');
            $table->timestamp('read_at')->nullable();

            // Solicitud que originó el mensaje (p. ej. una EnvironmentRequest).
            $table->string('related_model_type')->nullable();
            $table->unsignedBigInteger('related_model_id')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index(['related_model_type', 'related_model_id'], 'citizen_messages_related_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citizen_messages');
    }
};

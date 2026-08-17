<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Solicitudes de la Dirección de Medio Ambiente.
     * Una sola tabla para los tres trámites, discriminada por request_type:
     * poda | tala | donacion.
     */
    public function up(): void
    {
        Schema::create('environment_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('folio')->unique();
            $table->string('request_type');
            $table->string('status')->default('nueva');
            $table->date('fecha_solicitud')->nullable();

            // Datos de la solicitud. Donación sólo captura nombre y domicilio;
            // el resto de los campos son de Poda y Tala.
            $table->string('nombre');
            $table->string('domicilio');
            $table->string('colonia')->nullable();
            $table->text('motivo')->nullable();
            $table->string('telefono_celular')->nullable();
            $table->string('telefono_fijo')->nullable();

            // Supervisión de la solicitud: lo captura la Dirección tras la inspección.
            $table->date('fecha_atencion')->nullable();
            $table->text('observaciones_inspeccion')->nullable();
            $table->string('inspector')->nullable();
            $table->string('persona_atendio')->nullable();
            $table->string('especie')->nullable();
            $table->string('cantidad')->nullable();
            $table->string('altura_arbol')->nullable();
            $table->string('coordenadas')->nullable();

            // Tala: cumplimiento de la compensación en árboles endémicos.
            $table->timestamp('compensacion_confirmada_at')->nullable();
            $table->unsignedBigInteger('compensacion_confirmada_por')->nullable();

            $table->timestamps();

            $table->index(['request_type', 'status']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('environment_requests');
    }
};

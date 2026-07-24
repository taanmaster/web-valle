<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Apartado que Catastro llena por cada solicitud de Permiso de Construcción
     * o Permiso de Uso de Suelo. Se genera automáticamente (uno por solicitud).
     */
    public function up(): void
    {
        Schema::create('urban_dev_castro_requests', function (Blueprint $table) {
            $table->id();

            // Relación con la solicitud de Desarrollo Urbano (una por solicitud)
            $table->foreignId('urban_dev_request_id')
                ->constrained('urban_dev_requests')
                ->cascadeOnDelete();

            // Estado de la captura: pendiente | en_captura | completado
            $table->string('status')->default('pendiente');

            // Fechas y cuenta predial
            $table->date('fecha_solicitud')->nullable();          // Fecha en que el ciudadano envió la solicitud
            $table->date('fecha_entrega_documentos')->nullable(); // Ingresada por personal admin
            $table->string('cuenta_predial')->nullable();

            // Contribuyente y predio
            $table->string('nombre_contribuyente')->nullable();
            $table->string('tipo_predio')->nullable();            // Urbano / Rústico / Ejidal
            $table->string('domicilio_predio')->nullable();

            // Ubicación y detalles
            $table->string('localidad_colonia_ejido')->nullable();
            $table->string('manzana_lote')->nullable();
            $table->decimal('superficie', 12, 2)->nullable();     // m2
            $table->string('uso_tramite')->nullable();            // Uso / trámite (Desarrollo Urbano)
            $table->string('url_expediente')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urban_dev_castro_requests');
    }
};

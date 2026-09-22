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
        Schema::create('urban_dev_request_reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('urban_dev_request_id');
            $table->foreign('urban_dev_request_id')->references('id')->on('urban_dev_requests')->onDelete('cascade');

            // proteccion_civil | medio_ambiente
            $table->string('dependency');

            // Solo aplica a medio_ambiente: alto_impacto | licencia_ambiental_funcionamiento | manejo_de_residuos
            $table->string('format')->nullable();

            // recibida | en_revision | emitida — se recalcula automáticamente al guardar.
            $table->string('status')->default('recibida');

            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable();
            $table->foreign('sent_by')->references('id')->on('users')->onDelete('set null');

            // Información capturada por Desarrollo Urbano para el oficio de envío
            $table->string('responsible_name')->nullable();
            $table->string('technical_responsible')->nullable();
            $table->string('construction_type')->nullable();
            $table->string('establishment_name')->nullable();
            $table->string('property_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            // Resolución capturada por la dependencia receptora
            $table->string('resolution')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('technical_notes')->nullable();
            $table->text('conditions_requirements')->nullable();
            $table->string('issued_by')->nullable();

            $table->string('resolution_document_name')->nullable();
            $table->text('resolution_document_s3_url')->nullable();
            $table->unsignedBigInteger('resolution_document_size')->nullable();

            $table->timestamp('resolved_at')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->foreign('resolved_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();

            $table->unique(['urban_dev_request_id', 'dependency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urban_dev_request_reviews');
    }
};

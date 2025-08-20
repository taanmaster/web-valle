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
        Schema::create('d_i_f_legal_processes', function (Blueprint $table) {
            $table->id();

            $table->string('status')->default('new'); // Estados posibles: Pre-evaluación, evaluación formal, pago de asesoria, inicio de asesoría, llenado de cedula, entrega de documentación, estudio socioeconómico, gestión ante el municipio

            $table->string('case_num')->unique(); // Número de expediente o caso
            $table->string('advised_person'); // Persona asesorada
            $table->string('advised_street_name')->nullable();
            $table->string('advised_street_num')->nullable();
            $table->string('advised_zip_code')->nullable();
            $table->string('advised_colony')->nullable();
            $table->string('advised_phone')->nullable();
            $table->string('advised_age')->nullable();
            $table->string('advised_ocupation')->nullable();
            $table->string('advised_gender')->nullable(); // Masculino/Femenino
            $table->string('advised_median_income')->nullable(); // Ingreso Semanal
            $table->string('advised_children_qty')->nullable();

            $table->string('sued_person'); // Persona demandada
            $table->string('sued_street_name')->nullable();
            $table->string('sued_street_num')->nullable();
            $table->string('sued_zip_code')->nullable();
            $table->string('sued_colony')->nullable();
            $table->string('sued_age')->nullable();
            $table->string('sued_ocupation')->nullable();
            $table->string('sued_gender')->nullable(); // Masculino/Femenino
            $table->string('sued_median_income')->nullable(); // Ingreso Semanal
            $table->string('relation_with_advised')->nullable(); // Parentezco con asesorado

            // Motivo de Asesoría y Observaciones
            $table->text('reason_for_advisory')->nullable();
            $table->text('observations')->nullable();

            // Información Adicional
            $table->string('cost')->nullable();
            $table->integer('socio_economic_test_id')->nullable()->unsigned(); // Un estudio socioeconomico puede estar ligado a varios casos.

            // Campo created_at = fecha de ingreso
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_legal_processes');
    }
};

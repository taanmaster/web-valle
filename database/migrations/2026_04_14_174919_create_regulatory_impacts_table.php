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
        Schema::create('regulatory_impacts', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->enum('type', ['air', 'exencion']);
            $table->foreignId('dependency_id')->constrained('backoffice_dependencies')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('show_in_front')->default(false);
            $table->enum('dictamen_status', ['pendiente', 'rechazado', 'aprobado'])->default('pendiente');
            $table->string('dictamen_file')->nullable();
            $table->string('dictamen_s3_url')->nullable();
            $table->string('formato_solicitud')->nullable();
            $table->string('formato_solicitud_s3_url')->nullable();

            // Campos exclusivos de AIR
            $table->string('nombre_propuesta')->nullable();
            $table->date('fecha_vigencia')->nullable();
            $table->string('autoridad_emisora')->nullable();
            $table->text('objeto_programa')->nullable();
            $table->string('tipo_ordenamiento')->nullable();
            $table->string('materias_reguladas')->nullable();
            $table->string('sectores_regulados')->nullable();
            $table->string('sujetos_regulados')->nullable();
            $table->text('indice_regulacion')->nullable();
            $table->text('tramites_relacionados')->nullable();

            // Campos exclusivos de Exención
            $table->string('titulo_regulacion')->nullable();
            $table->string('nombre_cargo')->nullable();
            $table->date('fecha_envio')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regulatory_impacts');
    }
};

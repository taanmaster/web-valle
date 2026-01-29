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
        Schema::create('simplification_agendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dependency_id');
            $table->string('unique_code')->nullable();
            $table->string('name');
            
            // Criterios (Checkboxes)
            $table->boolean('high_frequency')->default(false);
            $table->boolean('priority_grupos')->default(false);
            $table->boolean('high_burocratic_cost')->default(false);
            $table->boolean('in_person')->default(false);
            $table->boolean('air_commitment')->default(false);
            $table->boolean('others')->default(false);
            
            // Descripciones
            $table->text('description')->nullable();
            $table->text('brief')->nullable();
            
            // Plan de Acción
            $table->text('diagnostic')->nullable();
            $table->text('simplification_action')->nullable();
            $table->text('digitalizacion_action')->nullable();
            $table->text('final_goal')->nullable();
            
            // Cronograma y Responsables
            $table->date('date_start')->nullable();
            $table->date('end_date')->nullable();
            $table->string('progress_percentage')->nullable();
            $table->string('responsible')->nullable();
            $table->string('semester')->nullable();
            
            // Estado activo
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('dependency_id')
                  ->references('id')
                  ->on('regulatory_agenda_dependencies')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simplification_agendas');
    }
};

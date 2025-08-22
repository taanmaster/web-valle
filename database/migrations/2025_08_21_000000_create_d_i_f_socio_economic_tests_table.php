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
        // Tabla principal de estudios socioeconómicos
        Schema::create('d_i_f_socio_economic_tests', function (Blueprint $table) {
            $table->id();
            
            // Información básica del ciudadano
            $table->integer('coordination_id')->unsigned();
            $table->integer('citizen_id')->unsigned();
            $table->string('citizen_name');
            $table->string('citizen_last_name');
            $table->string('citizen_curp', 18)->unique();
            $table->string('citizen_phone', 20);
            $table->text('citizen_address');
            $table->integer('citizen_age')->nullable();
            
            // Estado del estudio
            $table->string('status')->default('draft');
            $table->integer('current_step')->default(1);
            $table->boolean('can_go_back')->default(false);
            
            // Puntajes por paso
            $table->integer('step_1_score')->nullable();
            $table->integer('step_2_score')->nullable();
            $table->integer('step_3_score')->nullable();
            $table->integer('step_4_score')->nullable();
            $table->integer('step_5_score')->nullable();
            $table->integer('total_score')->nullable();
            
            // Respuestas por paso (JSON)
            $table->json('step_1_answers')->nullable();
            $table->json('step_2_answers')->nullable();
            $table->json('step_3_answers')->nullable();
            $table->json('step_4_answers')->nullable();
            $table->json('step_5_answers')->nullable();
            
            // Datos del Paso 1: Información básica y tipo de apoyo
            $table->string('support_type')->nullable();
            $table->string('reference_phone', 20)->nullable();
            
            // Datos del Paso 2: Proveedor económico
            $table->string('marital_status')->nullable();
            $table->string('provider_education')->nullable();
            $table->string('provider_job_status')->nullable();

            // Datos del Paso 3: Estructura familiar (el número de dependientes se maneja en tabla separada)
            $table->integer('dependents_count')->default(0);
            
            // Datos del Paso 4: Estructura económica
            $table->decimal('monthly_expenses', 10, 2)->nullable();
            $table->decimal('monthly_debt', 10, 2)->nullable();
            $table->decimal('monthly_savings', 10, 2)->nullable();
            $table->string('income_level')->nullable();
            $table->string('expense_level')->nullable();
            
            // Datos del Paso 5: Salud y vivienda
            $table->string('health_problem')->nullable();
            $table->string('housing_problem')->nullable();
            $table->text('final_observations')->nullable();
            
            // Metadatos de aprobación
            $table->integer('created_by')->unsigned();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index(['status', 'created_at']);
            $table->index(['coordination_id', 'status']);
            $table->index(['citizen_curp']);
            $table->index(['current_step', 'status']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_socio_economic_tests');
    }
};

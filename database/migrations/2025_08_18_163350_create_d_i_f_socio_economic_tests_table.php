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
        Schema::create('d_i_f_socio_economic_tests', function (Blueprint $table) {
            $table->id();

            // Información del ciudadano
            $table->integer('citizen_id')->unsigned()->nullable();
            $table->string('citizen_name');
            $table->string('citizen_last_name');
            $table->string('citizen_curp', 18)->unique();
            $table->string('citizen_phone')->nullable();
            $table->text('citizen_address')->nullable();
            
            // Control del formulario
            $table->enum('status', ['draft', 'completed', 'approved', 'rejected'])->default('draft');
            $table->integer('current_step')->default(1);
            
            // Respuestas del formulario (JSON)
            $table->json('step_1_answers')->nullable();
            $table->json('step_2_answers')->nullable();
            $table->json('step_3_answers')->nullable();
            $table->json('step_4_answers')->nullable();
            $table->json('step_5_answers')->nullable();
            $table->json('step_6_answers')->nullable();
            $table->json('step_7_answers')->nullable();
            
            // Resultados
            $table->integer('total_score')->default(0);
            $table->string('recommended_support_type')->nullable();
            $table->decimal('recommended_amount', 10, 2)->nullable();
            
            // Auditoría
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('notes')->nullable();
            
            // Índices
            $table->index('citizen_curp');
            $table->index('status');
            $table->index('created_by');

            $table->timestamps();
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

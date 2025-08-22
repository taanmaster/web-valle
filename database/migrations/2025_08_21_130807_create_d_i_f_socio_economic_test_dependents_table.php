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
        Schema::create('d_i_f_set_dependents', function (Blueprint $table) {
            $table->id();

            // Información del dependiente
            $table->integer('socio_economic_test_id')->unsigned();
            $table->string('name');
            $table->string('relationship'); // hijo, padre, madre, hermano, etc.
            $table->integer('age');
            $table->string('education_level')->nullable();
            $table->string('employment_status')->nullable();
            $table->boolean('contributes_income')->default(false);
            $table->decimal('monthly_contribution', 8, 2)->nullable();
            
            // Campos adicionales del formulario original
            $table->string('schooling')->nullable(); // mantener compatibilidad
            $table->string('marital_status')->nullable();
            $table->string('weekly_income')->nullable();
            $table->string('monthly_income')->nullable();
            $table->string('occupation')->nullable();

            $table->timestamps();
            
            // Índices
            $table->index(['socio_economic_test_id', 'relationship']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_set_dependents');
    }
};

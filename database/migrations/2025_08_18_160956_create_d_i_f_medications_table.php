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
        Schema::create('d_i_f_medications', function (Blueprint $table) {
            $table->id();

            $table->string('generic_name');
            $table->string('commercial_name');
            $table->text('description')->nullable();
            
            $table->text('formula')->nullable();

            $table->string('type')->nullable(); // Presentación : Tableta, Cápsula, Píldora, Supositorio, Jarabe, Gotas
            $table->string('type_num')->nullable(); // Cantidad (ej. 30, 500)
            $table->string('type_dosage')->nullable(); // Unidad de medida (ej. mg, gr, ml)

            $table->string('use_type')->nullable(); // Via de Administración: Oral, Tópica, Oftálmica, Ótica, Inyectable

            $table->date('expiration_date');
            $table->boolean('is_active')->default(true);

            // Campo created_at = fecha de ingreso
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_medications');
    }
};

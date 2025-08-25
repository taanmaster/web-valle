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
        Schema::create('d_i_f_location_assignments', function (Blueprint $table) {
            $table->id();

            // Esta tabla vincula una Ubicación con una Asignación
            // Las asignación pueden ser para un Programa o una Asistencia
            // Los programas y asistencias existen en diferentes bases de datos
            // En la vista solo se debe recuperar el nombre del modelo para verificar la asignación.
            // En el detalle de la Ubicación aparencerán todas las asignaciónes configuradas.
            $table->integer('location_id')->unsigned();
            $table->string('model_type'); // Nombre Tipo de Modelo: Programa o Asistencia
            $table->integer('model_id')->unsigned(); // ID del Modelo (Programa o Asistencia)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_location_assignments');
    }
};

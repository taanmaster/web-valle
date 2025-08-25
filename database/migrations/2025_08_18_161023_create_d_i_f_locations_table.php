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
        Schema::create('d_i_f_locations', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('street_name');
            $table->string('street_num');
            $table->string('zip_code');
            $table->string('colony')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('type'); // Tipo de Locación: Consultorio, Módulo Móvil, Clínica.

            // Campo created_at = fecha de ingreso
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_locations');
    }
};

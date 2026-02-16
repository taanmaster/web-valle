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
        Schema::create('appointment_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->tinyInteger('day_of_week')->comment('0=Domingo, 1=Lunes, ..., 6=Sábado');
            $table->time('start_time')->comment('Hora de inicio del rango');
            $table->time('end_time')->comment('Hora de fin del rango');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_schedules');
    }
};

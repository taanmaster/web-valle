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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del trámite');
            $table->string('slug')->unique()->comment('Slug URL-friendly');
            $table->foreignId('backoffice_dependency_id')->constrained('backoffice_dependencies')->onDelete('cascade');
            $table->text('description')->nullable()->comment('Descripción del trámite');
            $table->integer('slot_duration')->default(30)->comment('Duración de cada cita en minutos');
            $table->boolean('status')->default(true)->comment('Activo/Inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

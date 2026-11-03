<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_lighting_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('folio')->nullable();
            $table->string('status')->default('recibida');

            // Datos del solicitante
            $table->string('full_name');
            $table->string('phone', 20);
            $table->string('email')->nullable();

            // Ubicación del reporte
            $table->string('colony');
            $table->string('street');
            $table->string('number', 50)->nullable();
            $table->string('between_streets')->nullable();
            $table->string('references')->nullable();
            $table->text('map_url')->nullable();
            $table->string('location_photo_name')->nullable();
            $table->text('location_photo_s3_url')->nullable();

            // Información del problema
            $table->text('description');
            $table->string('pole_number')->nullable();
            $table->string('problem_since')->nullable();

            $table->boolean('terms_accepted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_lighting_requests');
    }
};

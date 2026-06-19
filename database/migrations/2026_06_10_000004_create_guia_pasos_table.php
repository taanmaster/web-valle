<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guia_pasos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guia_id')->constrained('guias')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('imagen_apoyo')->nullable();
            $table->string('enlace_texto')->nullable();
            $table->string('enlace_url')->nullable();
            $table->text('pregunta_frecuente')->nullable();
            $table->text('mensaje_advertencia')->nullable();
            $table->string('archivo_adjunto')->nullable();
            $table->unsignedInteger('orden')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guia_pasos');
    }
};
